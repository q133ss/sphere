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
        return $ticket;
    }
    public function reply(Request $request, Ticket $ticket){
        $text = $request->text;
        $ticket->status = 'user';
        $ticket->save();
        $ticket->messages()->create([
            'user_id' => auth()->id(),
            'text' => $text
        ]);
        return back();
    }
    public function close(Tiket $ticket){
        $ticket->status = 'closed';
        return back();
    }
}
