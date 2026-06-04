<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Lowongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function store(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role !== 'pelamar') {
            abort(403);
        }

        $lowongan = Lowongan::findOrFail($id);

        $alreadyAccepted = Application::where('user_id', Auth::id())
            ->acceptedWithinMonths(6)
            ->exists();
        if ($alreadyAccepted) {
            return redirect()->route('lowongan.show', $lowongan->id)
                ->with('error', 'Anda sudah diterima dalam 6 bulan terakhir dan tidak dapat melamar lagi.');
        }

        $alreadyApplied = Application::where('user_id', Auth::id())
            ->where('lowongan_id', $lowongan->id)
            ->whereIn('status', ['submitted', 'review', 'interview', 'accepted'])
            ->exists();

        if ($alreadyApplied) {
            return redirect()->route('lowongan.show', $lowongan->id)
                ->with('error', 'Anda sudah mengirim lamaran untuk lowongan ini.');
        }

        $data = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'cover_letter' => 'nullable|string',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cvs', 'public');
        }

        $application = Application::create([
            'user_id' => Auth::id(),
            'lowongan_id' => $lowongan->id,
            'name' => $data['name'] ?? Auth::user()->name,
            'email' => $data['email'] ?? Auth::user()->email,
            'cv_path' => $cvPath,
            'cover_letter' => $data['cover_letter'] ?? null,
            'status' => 'submitted',
        ]);

        // initialize history
        $application->addHistory('submitted', Auth::id());

        return redirect()->route('lowongan.show', $lowongan->id)->with('success', 'Lamaran berhasil dikirim.');
    }

    public function updateStatus(Request $request, $id)
    {
        $application = Application::findOrFail($id);

        // only perusahaan who owns the lowongan can change status
        if (!Auth::check() || Auth::user()->role !== 'perusahaan') {
            abort(403);
        }

        if ($application->lowongan->user_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'status' => 'required|in:submitted,review,interview,accepted,rejected',
        ]);

        $application->status = $data['status'];
        $application->accepted_at = $data['status'] === 'accepted' ? now() : null;
        $application->save();

        // append history entry
        $application->addHistory($data['status'], Auth::id());

        return back()->with('success', 'Status pelamar berhasil diperbarui.');
    }
}
