<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminChatController extends Controller
{
    public function index()
{
    $users = \App\Models\User::all();

    foreach ($users as $user) {
        $user->has_unread_messages = \App\Models\Chat::query()
            ->where('user_id', $user->id)
            ->where('is_from_user', true)
            ->where('is_read', false)
            ->exists();
    }

    return view('admin.chat.index', compact('users'));
}

    public function fetch(Request $request)
{
    $userId = $request->query('user_id');
    $messages = Chat::where('user_id', $userId)
        ->orderBy('created_at')
        ->get()
        ->map(function ($chat) {
            return [
                'message' => $chat->message,
                'is_from_user' => $chat->is_from_user,
                'created_at' => $chat->created_at->toDateTimeString(),
            ];
        });

    return response()->json($messages);
}

   public function send(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'message' => 'required|string'
    ]);

    try {
        $chat = Chat::create([
            'user_id' => $request->user_id,
            'admin_id' => Auth::guard('admin')->id(),
            'message' => $request->message,
            'is_from_user' => false,
            'from' => 'admin'
        ]);

        return response()->json(['status' => 'sent', 'message' => $chat]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Gagal mengirim pesan.',
            'error' => $e->getMessage()
        ], 500);
    }
}
public function markAsRead(Request $request)
{
    $userId = $request->user_id;

    \App\Models\Chat::where('user_id', $userId)
        ->where('is_from_user', true)
        ->where('is_read', false)
        ->update(['is_read' => true]);

    return response()->json(['status' => 'success']);
}

}
