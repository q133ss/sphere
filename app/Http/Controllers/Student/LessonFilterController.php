<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LessonFilterController extends Controller
{
    public function filter(Request $request){
        $lessons = auth()->user()->student_lessons()->with(['teacher', 'subject'])->where('status', $request->filter)->get();
        return view('ajax.lessons.index', compact('lessons'))->render();
    }
}
