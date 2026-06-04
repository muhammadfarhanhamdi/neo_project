<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private function ensureAdmin(): void
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403);
        }
    }

    public function edit($id)
    {
        $this->ensureAdmin();

        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $this->ensureAdmin();

        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'nullable|string|max:50|unique:users,nim,' . $user->id,
            'phone_number' => 'nullable|string|max:30',
        ]);

        $user->update($data);

        return redirect()->route('admin.alumni.index')->with('status', 'Profil pengguna diperbarui.');
    }
}
