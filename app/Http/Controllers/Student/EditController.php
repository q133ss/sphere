<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class EditController extends Controller
{
    public function index(){
        return view('student.edit');
    }

    public function update(Request $request){
        $user = User::find(Auth()->user()->id);
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->lastname = $request->lastname;
        $user->about = $request->about;
        $user->phone = $request->phone;
        $user->email = $request->email;
        if(isset($request->password)){
            if($request->password == $request->password_confirm){
                $user->password = bcrypt($request->password);
            }
        }
        $user->save();
        return redirect()->back();
    }
}
