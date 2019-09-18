<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    //
    public function get(){
        //return Notification::all();
        $unreadNotifications=Auth::user()->unreadNotifications;
        $fechaActual=date('Y-m-d');
        foreach($unreadNotifications as $noti){
            if($fechaActual!=$noti->created_at->toDateString()){
                $noti->markAsRead();
            }
        }

        return Auth::user()->unreadNotifications;
    }
}
