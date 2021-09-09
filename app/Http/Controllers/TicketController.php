<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
class TicketController extends Controller
{
    public function index(){
        $tickets = auth()->user()->isAdmin() ? Ticket::all() : auth()->user()->tickets()->get();
        return $tickets;
    }
    public function store(Request $request){
        $request->validate([
            'text' => 'required'
        ]);
        $data = $request->only('text');
        $data['user_id'] = auth()->id();
        $ticket = Ticket::create($data);
        $ticket->status = 'user';
        return $ticket;
    }
    public function getMessages(Ticket $ticket){
        return $ticket->messages;
    }
    public function reply(Request $request, Ticket $ticket){
        $text = $request->text;
        $ticket->status = auth()->user()->role->name == 'admin' ? 'admin' : 'user';
        $ticket->save();
        $message = $ticket->messages()->create([
            'user_id' => auth()->id(),
            'text' => $text
        ]);
        return $message->load('user');
    }
    public function close(Tiket $ticket){
        $ticket->status = 'closed';
        return back();
    }
}
