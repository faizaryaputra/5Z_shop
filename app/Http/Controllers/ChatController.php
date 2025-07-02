<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;


class ChatController extends Controller
{
   public function send(Request $request)
{
    $request->validate([
        'message' => 'required|string|max:1000',
    ]);

    if (!Auth::check()) {
        return response()->json(['status' => 'error', 'message' => 'Unauthenticated'], 401);
    }

    $chat = Chat::create([
        'user_id' => Auth::id(),
        'message' => $request->message,
        'from' => 'user',
        'is_from_user' => true,
    ]);

    return response()->json(['status' => 'sent', 'chat' => $chat]);
}
    public function fetch()
{
    if (!Auth::check()) {
        return response()->json(['status' => 'error', 'message' => 'Unauthenticated'], 401);
    }

    $userId = Auth::id();

    $messages = Chat::with('user')
        ->where('user_id', $userId) // ✅ Ambil hanya pesan user ini
        ->orderBy('created_at')
        ->get()
        ->map(function ($chat) {
            return [
                'from' => $chat->from,
                'name' => $chat->from === 'admin' ? 'Admin' : ($chat->user->name ?? 'User'),
                'message' => $chat->message,
            ];
        });

    return response()->json([
        'messages' => $messages
    ]);
}
}
