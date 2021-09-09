<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Subject;
class UserController extends Controller
{
    public function showProfile(){
        $user = auth()->user();
        $user->load(['files']);
        $userSubjects = $user->subjects->map( function($item) { return $item->id;})->all();
        $subjects = Subject::all();
        return view('teacher.profile', compact('user', 'subjects', 'userSubjects'));
    }
    public function showStudents(){
        $students = auth()->user()->students()->paginate(25);
        return view('teacher.students', compact('students'));
    }
}
