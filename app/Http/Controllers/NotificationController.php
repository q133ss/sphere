<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
class NotificationController extends Controller
{
    public function index(){
        return auth()->user()->notifications;
    }
    public function read(){
        return auth()->user()->notifications()->update(['read' => 1]);
    }
    public function destroy(Notification $notification){
        if(auth()->id() != $notification->user_id ) return response()->json(['message' => '403'], 403);
        $notification->delete();
    }
}
