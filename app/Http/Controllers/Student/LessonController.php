<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Lesson;
class LessonController extends Controller
{
    public function index(){
        $lessons = auth()->user()->student_lessons()->with(['teacher', 'subject'])->get();
        return view('student.lessons.index', compact('lessons'));
    }
    public function show(Request $request, Lesson $lesson){
        if($lesson->student_id != auth()->id()) abort(403);
        $id = $lesson->id;
        return view('student.lessons.show', compact('id'));
    }
}
