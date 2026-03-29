<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ INI YANG BENAR
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

// use App\Events\MessageSent;

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
    try {

        $request->validate([
            'id_chat' => 'required',
            'message' => 'required|string',
        ]);

        $user = auth()->user();

        $messageData = [
            'id_chat' => $request->id_chat,
            'sender_id' => $user->id_user,
            'sender_role' => 'guru',
            'message' => $request->message,
            'created_at' => now(),
        ];

        // simpan pesan
        DB::table('messages')->insert($messageData);

        // update chat
        DB::table('chats')
            ->where('id_chat', $request->id_chat)
            ->update([
                'last_message' => $request->message,
                'last_time' => now(),
            ]);

        // 🔥 broadcast realtime
        event(new MessageSent($messageData));

        return response()->json([
            'success' => true,
            'message' => $messageData,
            
            
        ]);

    } catch (\Exception $e) {

        \Log::error('SEND MESSAGE ERROR', [
            'error' => $e->getMessage(),
            'line' => $e->getLine()
        ]);

        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
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
                )->message,
            ];
        });

        return response()->json($result);
    }

    /*
     |--------------------------------------------------------------------------
     | HALAMAN SISWA
     |--------------------------------------------------------------------------
     */
    public function indexSiswa()
    {
        return view('siswa.pesan');
    }

    /*
    |--------------------------------------------------------------------------
    | LIST CHAT SISWA
    |--------------------------------------------------------------------------
    */
    public function getChatListSiswa()
    {
        $user = auth()->user();

        // ambil siswa
        $siswa = DB::table('siswa')
            ->where('id_user', $user->id_user)
            ->first();

        if (! $siswa) {
            return response()->json([]);
        }

        $chats = DB::table('chats')
            ->where('id_siswa', $siswa->id_siswa)
            ->orderByDesc('id_chat')
            ->get();

        $data = $chats->map(function ($chat) {

            // 🔥 ambil nama guru
            $guru = DB::table('guru')
                ->where('id_user', $chat->id_user_tujuan)
                ->first();

            return [
                'id_chat' => $chat->id_chat,
                'name' => $guru->nama ?? 'Guru BK',
                'last_message' => $chat->last_message,
            ];
        });

        return response()->json($data);
    }

    /*
    |--------------------------------------------------------------------------
    | AMBIL MESSAGES
    |--------------------------------------------------------------------------
    */
    public function getMessagesSiswa($id)
    {
        $user = auth()->user();

        // 🔥 ambil data siswa dari user
        $siswa = DB::table('siswa')
            ->where('id_user', $user->id_user)
            ->first();

        if (! $siswa) {
            abort(403);
        }

        // 🔥 ambil chat
        $chat = DB::table('chats')
            ->where('id_chat', $id)
            ->first();

        // 🔥 VALIDASI YANG BENAR
        if (! $chat || $chat->id_siswa != $siswa->id_siswa) {
            abort(403);
        }

        // ambil messages
        $messages = DB::table('messages')
            ->where('id_chat', $id)
            ->orderBy('id_message')
            ->get();

        return response()->json($messages);
    }

    /*
    |--------------------------------------------------------------------------
    | KIRIM PESAN
    |--------------------------------------------------------------------------
    */
public function sendMessageSiswa(Request $request)
{
    try {

        $request->validate([
            'id_chat' => 'required',
            'message' => 'required|string',
        ]);

        $user = auth()->user();

        $siswa = DB::table('siswa')
            ->where('id_user', $user->id_user)
            ->first();

        $chat = DB::table('chats')
            ->where('id_chat', $request->id_chat)
            ->first();

        if (! $chat || $chat->id_siswa != $siswa->id_siswa) {
            return response()->json(['success' => false, 'error' => 'Forbidden'], 403);
        }

        // 🔥 INI HARUS DI SINI
        $message = [
            'id_chat' => $request->id_chat,
            'sender_id' => $user->id_user,
            'sender_role' => 'siswa',
            'message' => $request->message,
            'created_at' => now(),
        ];

        DB::table('messages')->insert($message);

        DB::table('chats')
            ->where('id_chat', $request->id_chat)
            ->update([
                'last_message' => $request->message,
                'last_time' => now(),
            ]);

        // 🔥 INI JUGA DI SINI
        event(new MessageSent($message));

        return response()->json([
            'success' => true,
            'message' => $message
        ]);

    } catch (\Exception $e) {

        \Log::error('SEND MESSAGE ERROR', [
            'error' => $e->getMessage(),
            'line' => $e->getLine()
        ]);

        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
}
}
