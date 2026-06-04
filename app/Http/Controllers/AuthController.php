<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:pelamar,perusahaan',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        Auth::login($user);

        if ($user->role === 'perusahaan') {
            return redirect()->route('perusahaan.dashboard');
        }

        return redirect()->route('pelamar.dashboard');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'role' => 'required|in:pelamar,perusahaan,admin',
        ]);

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->role !== $data['role']) {
                Auth::logout();
                return back()->withErrors(['role' => 'Peran akun tidak cocok dengan pilihan Anda.']);
            }

            if ($user->role === 'perusahaan') {
                return redirect()->route('perusahaan.dashboard');
            }

            if ($user->role === 'admin') {
                return redirect()->route('admin.alumni.index');
            }

            return redirect()->route('pelamar.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau kata sandi salah.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
