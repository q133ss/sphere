<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Lesson;
class LessonController extends Controller
{
    public function index(){
        $lessons = auth()->user()->teacher_lessons()->with(['student', 'subject'])->get();
        return view('teacher.lessons.index', compact('lessons'));
    }
    public function show(Request $request, Lesson $lesson){
        if( $lesson->teacher_id != auth()->id()) abort(403);
        $id = $lesson->id;
        return view('teacher.lessons.show', compact('id'));
    }
}
