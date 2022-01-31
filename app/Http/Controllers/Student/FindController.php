<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Subject;

class FindController extends Controller
{
    public function index(){
        $subjects = Subject::get();
        return view('student.find.index', compact('subjects'));
    }
}
