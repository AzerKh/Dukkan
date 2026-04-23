<?php
namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userId = Auth::id();
        $contacts = User::where('id', '!=', $userId)
            ->whereIn('id', function ($query) use ($userId) {
                $query->select('sender_id')->from('messages')->where('receiver_id', $userId)
                    ->union(
                        DB::table('messages')->select('receiver_id')->where('sender_id', $userId)
                    );
            })->get();

        return view('chat.index', compact('contacts'));
    }

    public function show($userId)
    {
        $contact = User::findOrFail($userId);
        $authId  = Auth::id();

        Message::where('sender_id', $userId)
            ->where('receiver_id', $authId)
            ->update(['is_read' => true]);

        $messages = Message::where(function ($q) use ($authId, $userId) {
                $q->where('sender_id', $authId)->where('receiver_id', $userId);
            })->orWhere(function ($q) use ($authId, $userId) {
                $q->where('sender_id', $userId)->where('receiver_id', $authId);
            })
            ->orderBy('created_at')
            ->get();

        return view('chat.show', compact('contact', 'messages'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'body'        => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'body'        => $request->body,
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id'         => $message->id,
                'body'       => e($message->body),
                'sender_id'  => $message->sender_id,
                'created_at' => $message->created_at->format('H:i'),
            ]
        ]);
    }

    public function fetch(Request $request)
    {
        $request->validate([
            'contact_id' => 'required|exists:users,id',
            'last_id'    => 'nullable|integer',
        ]);

        $authId    = Auth::id();
        $contactId = $request->contact_id;
        $lastId    = $request->last_id ?? 0;

        $messages = Message::where('id', '>', $lastId)
            ->where('sender_id', $contactId)
            ->where('receiver_id', $authId)
            ->orderBy('created_at')
            ->get()
            ->map(fn($m) => [
                'id'         => $m->id,
                'body'       => e($m->body),
                'sender_id'  => $m->sender_id,
                'created_at' => $m->created_at->format('H:i'),
            ]);

        return response()->json($messages);
    }
}