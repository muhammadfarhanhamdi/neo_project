<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\Common\Creator\WriterFactory;

class AlumniTrackingController extends Controller
{
    public function index(Request $request)
    {
        $this->ensureAdminAccess();

        $nim = trim((string) $request->query('nim', ''));
        $statusFilter = $this->normalizeStatusFilter((string) $request->query('status', 'all'));

        $alumniQuery = $this->buildAlumniQuery($nim, $statusFilter)
            ->with(['applications' => function ($query) {
                $query->with('lowongan')->latest();
            }])
            ->orderBy('nim');

        $alumni = $alumniQuery->paginate(20)->withQueryString();

        $alumni->getCollection()->transform(function (User $pelamar) {
            $acceptedApplication = $pelamar->applications->firstWhere('status', 'accepted');

            $pelamar->setAttribute('is_employed', (bool) $acceptedApplication);
            $pelamar->setAttribute('accepted_application', $acceptedApplication);
            $pelamar->setAttribute('total_applications', $pelamar->applications->count());

            return $pelamar;
        });

        $totalWithNim = User::where('role', 'pelamar')->whereNotNull('nim')->where('nim', '!=', '')->count();
        $employedCount = User::where('role', 'pelamar')
            ->whereNotNull('nim')
            ->where('nim', '!=', '')
            ->whereHas('applications', function ($query) {
                $query->where('status', 'accepted');
            })
            ->count();

        $unemployedCount = max($totalWithNim - $employedCount, 0);
        $missingNimCount = User::where('role', 'pelamar')->where(function ($query) {
            $query->whereNull('nim')->orWhere('nim', '');
        })->count();
        $employmentRate = $totalWithNim > 0 ? (int) round(($employedCount / $totalWithNim) * 100) : 0;

        $missingNimUsers = User::where('role', 'pelamar')
            ->where(function ($query) {
                $query->whereNull('nim')->orWhere('nim', '');
            })
            ->latest()
            ->take(8)
            ->get(['id', 'name', 'email', 'phone_number']);

        return view('admin.alumni_tracking', compact(
            'alumni',
            'nim',
            'statusFilter',
            'totalWithNim',
            'employedCount',
            'unemployedCount',
            'missingNimCount',
            'employmentRate',
            'missingNimUsers'
        ));
    }

    public function dashboard()
    {
        $this->ensureAdminAccess();

        $totalAlumni = User::where('role', 'pelamar')->count();
        $withNim = User::where('role', 'pelamar')->whereNotNull('nim')->where('nim', '!=', '')->count();
        $employed = User::where('role', 'pelamar')
            ->whereHas('applications', function ($q) { $q->where('status', 'accepted'); })
            ->count();

        $employmentRate = $withNim > 0 ? (int) round(($employed / $withNim) * 100) : 0;

        $recentVerified = User::where('role', 'pelamar')
            ->whereHas('applications', function ($q) { $q->where('status', 'accepted'); })
            ->with(['applications' => function ($q) { $q->latest(); }])
            ->latest()
            ->take(6)
            ->get(['id', 'name', 'nim']);

        // simple system logs stub (could be replaced with real activity log)
        $systemLogs = [
            ['time' => now()->subMinutes(5), 'message' => 'Admin memverifikasi 1 akun.'],
            ['time' => now()->subHours(1), 'message' => 'Sinkronisasi data ke PDDIKTI selesai.'],
            ['time' => now()->subHours(3), 'message' => 'Kegagalan login terdeteksi dari IP 192.168.1.15'],
        ];

        return view('admin.dashboard', compact('totalAlumni', 'withNim', 'employed', 'employmentRate', 'recentVerified', 'systemLogs'));
    }

    public function export(Request $request)
    {
        $this->ensureAdminAccess();

        $filters = $this->extractFilters($request);
        $alumni = $this->getExportAlumni($filters['nim'], $filters['status']);

        $fileName = 'alumni-tracking-' . now()->format('Ymd-His') . '.pdf';

        return Pdf::loadView('admin.alumni_export_pdf', [
            'alumni' => $alumni,
            'filters' => $filters,
            'generatedAt' => now(),
        ])->setPaper('a4', 'landscape')->download($fileName);
    }

    public function exportExcel(Request $request)
    {
        $this->ensureAdminAccess();

        $filters = $this->extractFilters($request);
        $alumni = $this->getExportAlumni($filters['nim'], $filters['status']);

        $fileName = 'alumni-tracking-' . now()->format('Ymd-His') . '.xlsx';
        $filePath = storage_path('app/' . $fileName);

        $writer = WriterFactory::createFromFile($filePath);
        $writer->openToFile($filePath);
        $writer->addRow(Row::fromValues([
            'NIM', 'Nama', 'Email', 'Status Kerja', 'Perusahaan', 'Posisi', 'Total Lamaran',
        ]));

        foreach ($alumni as $item) {
            $accepted = $item->applications->firstWhere('status', 'accepted');

            $writer->addRow(Row::fromValues([
                (string) $item->nim,
                (string) $item->name,
                (string) $item->email,
                $accepted ? 'Sudah Diterima' : 'Belum Diterima',
                $accepted && $accepted->lowongan ? (string) $accepted->lowongan->company : '-',
                $accepted && $accepted->lowongan ? (string) $accepted->lowongan->title : '-',
                (string) $item->applications->count(),
            ]));
        }

        $writer->close();

        return response()->download($filePath, $fileName)->deleteFileAfterSend(true);
    }

    public function show($id)
    {
        $this->ensureAdminAccess();

        $user = User::with('applications.lowongan')->findOrFail($id);

        return view('admin.alumni_show', compact('user'));
    }

    private function ensureAdminAccess(): void
    {
        $authUser = Auth::user();

        if (!$authUser || $authUser->role !== 'admin') {
            abort(403);
        }
    }

    private function normalizeStatusFilter(string $statusFilter): string
    {
        $allowed = ['all', 'employed', 'unemployed'];

        return in_array($statusFilter, $allowed, true) ? $statusFilter : 'all';
    }

    private function buildAlumniQuery(string $nim, string $statusFilter)
    {
        $query = User::query()
            ->where('role', 'pelamar')
            ->whereNotNull('nim')
            ->where('nim', '!=', '');

        if ($nim !== '') {
            $query->where('nim', 'like', "%{$nim}%");
        }

        if ($statusFilter === 'employed') {
            $query->whereHas('applications', function ($applicationQuery) {
                $applicationQuery->where('status', 'accepted');
            });
        }

        if ($statusFilter === 'unemployed') {
            $query->whereDoesntHave('applications', function ($applicationQuery) {
                $applicationQuery->where('status', 'accepted');
            });
        }

        return $query;
    }

    private function extractFilters(Request $request): array
    {
        return [
            'nim' => trim((string) $request->query('nim', '')),
            'status' => $this->normalizeStatusFilter((string) $request->query('status', 'all')),
        ];
    }

    private function getExportAlumni(string $nim, string $statusFilter)
    {
        return $this->buildAlumniQuery($nim, $statusFilter)
            ->with(['applications' => function ($query) {
                $query->with('lowongan')->latest();
            }])
            ->orderBy('nim')
            ->get();
    }
}
