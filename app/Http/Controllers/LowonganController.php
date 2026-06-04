<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Lowongan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LowonganController extends Controller
{
    public function index(Request $request)
    {
        $query = Lowongan::query();

        if ($request->filled('q')) {
            $q = $request->get('q');
            $query->where(function ($builder) use ($q) {
                $builder->where('title', 'like', "%{$q}%")
                    ->orWhere('company', 'like', "%{$q}%")
                    ->orWhere('location', 'like', "%{$q}%");
            });
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->get('location') . '%');
        }

        if ($request->filled('type')) {
            $types = (array) $request->get('type');
            $query->whereIn('type', $types);
        }

        if ($request->filled('seniority')) {
            $query->where('seniority', $request->get('seniority'));
        }

        $query->withCount('applications');

        $lowongans = $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('lowongan.search', compact('lowongans'));
    }

    public function show($id)
    {
        $lowongan = Lowongan::findOrFail($id);

        $userAccepted = false;
        $nextEligibleAt = null;
        $alreadyApplied = false;
        $isSaved = false;

        /** @var User|null $user */
        $user = Auth::user();

        if ($user && $user->role === 'pelamar') {
            $acceptedApplication = Application::where('user_id', $user->id)
                ->acceptedWithinMonths(6)
                ->orderByDesc('accepted_at')
                ->orderByDesc('updated_at')
                ->first();

            $userAccepted = $acceptedApplication !== null;

            if ($acceptedApplication) {
                $nextEligibleAt = $acceptedApplication->accepted_at ?? $acceptedApplication->updated_at;
                $nextEligibleAt = $nextEligibleAt?->copy()->addMonths(6);
            }

            $alreadyApplied = Application::where('user_id', $user->id)
                ->where('lowongan_id', $lowongan->id)
                ->whereIn('status', ['submitted', 'review', 'interview', 'accepted'])
                ->exists();
            $isSaved = $user->savedLowongans()
                ->where('lowongan_id', $lowongan->id)
                ->exists();
        }

        return view('lowongan.show', compact('lowongan', 'userAccepted', 'alreadyApplied', 'isSaved', 'nextEligibleAt'));
    }

    public function save($id)
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user || $user->role !== 'pelamar') {
            abort(403);
        }

        $lowongan = Lowongan::findOrFail($id);
        $user->savedLowongans()->syncWithoutDetaching([$lowongan->id]);

        return back()->with('success', 'Lowongan berhasil disimpan.');
    }

    public function unsave($id)
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user || $user->role !== 'pelamar') {
            abort(403);
        }

        $lowongan = Lowongan::findOrFail($id);
        $user->savedLowongans()->detach($lowongan->id);

        return back()->with('success', 'Lowongan telah dihapus dari simpanan.');
    }

    public function saved()
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user || $user->role !== 'pelamar') {
            abort(403);
        }

        $savedLowongans = $user->savedLowongans()
            ->withCount('applications')
            ->orderBy('saved_lowongans.created_at', 'desc')
            ->paginate(10);

        return view('pelamar.saved', compact('savedLowongans'));
    }

    public function create()
    {
        if (!Auth::check() || Auth::user()->role !== 'perusahaan') {
            abort(403);
        }

        return view('perusahaan.create_lowongan');
    }

    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'perusahaan') {
            abort(403);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:100',
            'seniority' => 'nullable|string|max:100',
            'salary_range' => 'nullable|string|max:100',
            'lama_kerja' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
        ]);

        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;
        $data['user_id'] = Auth::id();
        $data['company'] = $data['company'] ?? Auth::user()->name;

        Lowongan::create($data);

        return redirect()->route('perusahaan.dashboard')->with('success', 'Lowongan berhasil dibuat.');
    }
}
