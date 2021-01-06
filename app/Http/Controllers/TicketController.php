<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
class TicketController extends Controller
{
    public function index(){
        $tickets = auth()->user()->tickets()->paginate(25);
        return view('tickets.index', compact('tickets'));
    }
    public function show(Ticket $ticket){
        $ticket->load(['messages']);
        return view('tickets.show', compact('ticket'));
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
