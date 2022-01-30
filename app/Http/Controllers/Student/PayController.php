<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Payment;

class PayController extends Controller
{
    public function index(){
        $payments = Auth()->user()->payments;
        return view('student.pay', compact('payments'));
    }
}
