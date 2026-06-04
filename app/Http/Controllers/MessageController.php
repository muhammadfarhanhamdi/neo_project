<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $targetRole = $user->role === 'pelamar' ? 'perusahaan' : 'pelamar';

        $recipients = User::where('id', '!=', $user->id)
            ->where('role', $targetRole)
            ->orderBy('name')
            ->get();

        $messages = Message::with(['sender', 'receiver'])
            ->where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->latest()
            ->paginate(10);

        Message::where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return view('messages.index', compact('messages', 'recipients'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $targetRole = $user->role === 'pelamar' ? 'perusahaan' : 'pelamar';

        $data = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'subject' => 'nullable|string|max:255',
            'body' => 'required|string|max:5000',
        ]);

        $receiver = User::where('id', $data['receiver_id'])
            ->where('role', $targetRole)
            ->firstOrFail();

        Message::create([
            'sender_id' => $user->id,
            'receiver_id' => $receiver->id,
            'subject' => $data['subject'] ?? null,
            'body' => $data['body'],
            'is_read' => false,
            'read_at' => null,
        ]);

        return back()->with('success', 'Pesan berhasil dikirim.');
    }
}