<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function redirectTo() {
        $role_id = auth()->user()->role_id;
        switch ($role_id) {
            case 1: return '/admin_dashboard'; break;
            case 2: return '/student_dashboard'; break; 
            case 3: return '/teacher_dashboard'; break; 
            default: return '/'; break;
        }
    }
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
