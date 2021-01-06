<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ticket;
class TicketController extends Controller
{
    public function index(){
        $tickets = Ticket::with(['user'])->paginate(25);
        return view('admin.tickets.index', compact('tickets'));
    }
    public function show(Ticket $ticket){
        $ticket->load(['user', 'messages']);
        return view('admin.tickets.show', compact('ticket'));
    }
    public function reply(Request $request, Ticket $ticket){
        $text = $request->text;
        $ticket->status = 'admin';
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
