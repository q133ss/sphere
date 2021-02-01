<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ChatMessage;
class ChatController extends Controller
{
    public function users(){
        $user = auth()->user();
        $users = $user->role->name == 'teacher' ? $user->students : $user->teachers;
        return $users;
    }
    public function getMessages(Request $request){
        $id1 = auth()->id();
        $id2 = $request->id;
        $hash = min($id1, $id2) . '_' . max($id1, $id2);
        $messages = ChatMessage::with(['author:id,name,photo'])
            ->where('hash', $hash)
            ->get();
        return $messages;
    }
    public function message(Request $request){
        $request->validate([
            'text' => 'required|string',
            'id' => 'required'
        ]);
        $id1 = auth()->id();
        $id2 = $request->id;
        $hash = min($id1, $id2) . '_' . max($id1, $id2);
        $message = ChatMessage::create([
            'hash' => $hash,
            'author_id' => $id1,
            'text' => $request->text
        ]);
        $message->load(['author:id,name,photo']);
        return $message;
    }
}
