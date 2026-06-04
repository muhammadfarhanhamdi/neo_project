<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user || $user->role !== 'pelamar') {
            abort(403);
        }

        $profileCompleteness = $this->calculateProfileCompleteness($user);

        return view('pelamar.profile', compact('user', 'profileCompleteness'));
    }

    public function companyEdit()
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user || $user->role !== 'perusahaan') {
            abort(403);
        }

        $profileCompleteness = $this->calculateCompanyProfileCompleteness($user);

        return view('perusahaan.profile', compact('user', 'profileCompleteness'));
    }

    public function update(Request $request)
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user || $user->role !== 'pelamar') {
            abort(403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required','email','max:255', Rule::unique('users')->ignore($user->id)],
            'nim' => ['nullable', 'string', 'max:30', 'regex:/^[0-9]+$/', Rule::unique('users')->ignore($user->id)],
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'phone_number' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->nim = $data['nim'] ?? null;

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $user->profile_photo_path = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        $user->phone_number = $data['phone_number'] ?? null;
        $user->address = $data['address'] ?? null;
        $user->city = $data['city'] ?? null;
        $user->birth_date = $data['birth_date'] ?? null;
        $user->gender = $data['gender'] ?? null;
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('pelamar.profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }

    public function companyUpdate(Request $request)
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user || $user->role !== 'perusahaan') {
            abort(403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'phone_number' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $user->profile_photo_path = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        $user->phone_number = $data['phone_number'] ?? null;
        $user->address = $data['address'] ?? null;
        $user->city = $data['city'] ?? null;

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('perusahaan.profile.edit')->with('success', 'Profil perusahaan berhasil diperbarui.');
    }

    private function calculateProfileCompleteness($user): int
    {
        $fields = [
            $user->name,
            $user->email,
            $user->nim,
            $user->phone_number,
            $user->address,
            $user->city,
            $user->birth_date,
            $user->gender,
        ];

        $filled = collect($fields)->filter()->count();

        return (int) round(($filled / count($fields)) * 100);
    }

    private function calculateCompanyProfileCompleteness($user): int
    {
        $fields = [
            $user->name,
            $user->email,
            $user->profile_photo_path,
            $user->phone_number,
            $user->address,
            $user->city,
        ];

        $filled = collect($fields)->filter()->count();

        return (int) round(($filled / count($fields)) * 100);
    }
}
