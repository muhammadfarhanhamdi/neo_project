<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Lowongan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function perusahaan()
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'perusahaan') {
            abort(403);
        }

        $myLowongans = Lowongan::withCount('applications')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(8);

        $dashboardLowongans = Lowongan::withCount('applications')
            ->where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get();

        $recentApplications = Application::with(['lowongan', 'user'])
            ->whereHas('lowongan', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->latest()
            ->take(8)
            ->get();

        $dashboardApplications = $recentApplications->take(3);

        $stats = [
            'total_lowongan' => Lowongan::where('user_id', $user->id)->count(),
            'total_pelamar' => Application::whereHas('lowongan', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->count(),
            'scheduled_applications' => Application::whereHas('lowongan', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->where('status', 'review')->count(),
        ];

        return view('perusahaan.dashboard', compact('myLowongans', 'recentApplications', 'dashboardLowongans', 'dashboardApplications', 'stats'));
    }

    public function pelamar()
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'pelamar') {
            abort(403);
        }

        $myApplications = Application::with('lowongan')
            ->where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        $latestLowongans = Lowongan::latest()
            ->take(8)
            ->get();

        // recommended lowongans (simple: latest 4)
        $recommendedLowongans = Lowongan::latest()->take(4)->get();

        // popular companies (simple frequency)
        $popularCompanies = Lowongan::select('company', DB::raw('count(*) as cnt'))
            ->groupBy('company')
            ->orderByDesc('cnt')
            ->take(6)
            ->get();

        $profileFields = [
            $user->name,
            $user->email,
            $user->nim,
            $user->profile_photo_path,
            $user->phone_number,
            $user->address,
            $user->city,
            $user->birth_date,
            $user->gender,
        ];
        $profileCompleteness = (int) round((collect($profileFields)->filter()->count() / count($profileFields)) * 100);

        $stats = [
            'total_lamaran' => Application::where('user_id', $user->id)->count(),
            'lamaran_diterima_review' => Application::where('user_id', $user->id)
                ->whereIn('status', ['submitted', 'review'])
                ->count(),
            'lowongan_baru' => Lowongan::whereDate('created_at', '>=', now()->subDays(7))->count(),
        ];

        return view('pelamar.dashboard', compact('myApplications', 'latestLowongans', 'recommendedLowongans', 'popularCompanies', 'stats', 'profileCompleteness'));
    }

    public function pelamarHistory()
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'pelamar') {
            abort(403);
        }

        $applications = \App\Models\Application::with('lowongan')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(12);

        $profileFields = [
            $user->name,
            $user->email,
            $user->nim,
            $user->profile_photo_path,
            $user->phone_number,
            $user->address,
            $user->city,
            $user->birth_date,
            $user->gender,
        ];

        $profileCompleteness = (int) round((collect($profileFields)->filter()->count() / count($profileFields)) * 100);

        return view('pelamar.riwayat', compact('applications', 'user', 'profileCompleteness'));
    }

    // Company: list lowongans created by company
    public function lowongansSaya()
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'perusahaan') {
            abort(403);
        }

        $lowongans = Lowongan::where('user_id', $user->id)->latest()->paginate(12);

        return view('perusahaan.lowongan_saya', compact('lowongans'));
    }

    // Company: list pelamar for company's lowongans
    public function pelamarForCompany()
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'perusahaan') {
            abort(403);
        }

        $selectedLowonganId = request('lowongan_id');

        $companyLowongans = Lowongan::where('user_id', $user->id)
            ->latest()
            ->get(['id', 'title']);

        $applicationsQuery = Application::with(['lowongan', 'user'])
            ->whereHas('lowongan', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });

        if (!empty($selectedLowonganId)) {
            $applicationsQuery->where('lowongan_id', $selectedLowonganId);
        }

        $applications = $applicationsQuery
            ->latest()
            ->paginate(15);

        return view('perusahaan.pelamar_list', compact('applications', 'companyLowongans', 'selectedLowonganId'));
    }

    // Company: show specific lowongan owned by company
    public function showLowonganForCompany($id)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'perusahaan') {
            abort(403);
        }

        $lowongan = Lowongan::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        $latestApplications = Application::with('user')
            ->where('lowongan_id', $lowongan->id)
            ->latest()
            ->take(6)
            ->get();

        return view('perusahaan.lowongan_show', compact('lowongan', 'latestApplications'));
    }

    // Company: show specific applicant detail for owned lowongan
    public function showPelamarForCompany($id)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'perusahaan') {
            abort(403);
        }

        $application = Application::with(['lowongan', 'user'])->findOrFail($id);

        if (!$application->lowongan || $application->lowongan->user_id !== $user->id) {
            abort(403);
        }

        return view('perusahaan.pelamar_show', compact('application'));
    }
}
