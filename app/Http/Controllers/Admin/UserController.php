<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\UserNotificationEvent;
use App\User;
use Storage;
class UserController extends Controller
{
    public function showProfile(){
        $user = auth()->user();
        $user->load(['role', 'files']);
        return view('admin.profile', compact('user'));
    }
    public function index(Request $request){
        $users = User::with(['role']);
        if($request->has('requestOnly'))
            $users->whereRoleId(3)->whereConfirmRequest(1);
        $users = $users->paginate(25);
        $requests = User::whereRoleId(3)->whereConfirmRequest(1)->count();
        return view('admin.users.index', compact('users', 'requests'));
    }
    public function show(User $user){
        $user->load(['subjects', 'role', 'files']);
        return view('admin.users.show', compact('user'));
    }
    public function confirm(User $user){
        $user->confirm_request = 0;
        $user->confirmed = 1;
        $user->save();
        event(new UserNotificationEvent($user->id, 'Ваш профиль успешно прошел модерацию'));
        session()->flash('success', 'Профиль успешно подтвержден');
        return back();
    }
    public function destroy(User $user){
        if($user->photo) Storage::delete($user->photo);
        if($user->files->count()) 
            foreach($user->files as $file) Storage::delete($file->src);
        $user->delete();
        session()->flash('success', 'Пользователь успешно удален');
        return redirect()->route('admin.users.index');
    }
}
