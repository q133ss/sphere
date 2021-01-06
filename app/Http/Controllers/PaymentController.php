<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
class PaymentController extends Controller
{
    public function index(){
        $payments = auth()->user()->payments()->paginate(25);
        return view('payments.index', compact('payments'));
    }
    public function store(Request $request){
        $request->validate([
            'amount' => 'required|numeric|min:10'
        ]);
        Payment::create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'type' => 'in',
            'status' => 'success'
        ]);
        auth()->user()->increment('balance', $request->amount);
        session()->flash('success', 'Ваш счет успешно пополнен');
        return back();
    }
}
