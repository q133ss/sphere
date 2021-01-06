<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
class UserController extends Controller
{
    public function showProfile(){
        $user = auth()->user();
        $user->load(['files']);
        return view('student.profile', compact('user'));
    }
    public function showTeachers(){
        $teachers = auth()->user()->teachers()->paginate(25);
        return view('student.students', compact('teachers'));
    }
}
