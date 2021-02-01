<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Storage;
class UserController extends Controller
{
    public function uploadPhoto(Request $request){
        $user = auth()->user();
        $request->validate([
            'photo' => 'image|max:2048'
        ]);
        if($user->photo) Storage::delete($user->photo);
        $path = $request->file('photo')->store('photos');
        $user->photo = $path;
        $user->save();
        return $user->photo;
    }
    public function uploadDocs(Request $request){
        $user = auth()->user();
        $request->validate([
            'photo' => 'nullable|image|max:2048'
        ]);
    }
    public function update(Request $request){
        $user = auth()->user();
        $validator = [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'lesson_price' => 'nullable|numeric|min:0',
            'age' => 'nullable|numeric',
            'password' => 'nullable|string|min:6|max:255|confirmed'
        ];
        if($user->role->name == 'teacher')
            $validator['phone'] = 'required|string|max:255|unique:users,phone,'.$user->id;
        $request->validate($validator);
        $data = $request->except(['password', 'subjects']);
        if($request->password) $data['password'] = bcrypt($request->password);
        $data['confirm_request'] = $request->has('confirm_request');
        $user->update($data);
        $user->subjects()->sync($request->subjects);
        session()->flash('success', 'Профиль успешно обновлен');
        return back();
    }
}
