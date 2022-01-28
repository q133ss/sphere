<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $lessons = auth()->user()->student_lessons()->with(['teacher', 'subject'])->get();
        return view('student.dashboard', compact('lessons'));
    }
}
