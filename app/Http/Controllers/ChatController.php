<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; // ✅ INI YANG BENAR

class ChatController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Ambil semua chat yang ditujukan ke admin/guru ini
        $chats = Chat::where('id_user_tujuan', $user->id_user)
            ->orderBy('last_time', 'desc')
            ->get();

        return view('admin.pesan', compact('chats'));
    }

    public function getMessages($id)
    {
        $messages = Message::where('id_chat', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $message = Message::create([
            'id_chat' => $request->id_chat,
            'sender_id' => auth()->user()->id_user,
            'sender_role' => 'guru',
            'message' => $request->message,
        ]);

        Chat::where('id_chat', $request->id_chat)->update([
            'last_message' => $request->message,
            'last_time' => now(),
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'success' => true,
            'data' => $message,
        ]);
    }


public function getChatList()
{
    $userId = Auth::id();

    $chats = \App\Models\Chat::where('id_user_tujuan', $userId)
        ->with('siswa')
        ->get();

    $result = $chats->map(function ($chat) {
        return [
            'id_chat' => $chat->id_chat,
            'nama_anonim' => $chat->nama_anonim,
            'last_message' => optional(
                \App\Models\Message::where('id_chat', $chat->id_chat)->latest()->first()
            )->message
        ];
    });

    return response()->json($result);
}
}
