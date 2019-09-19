<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Credito;
use App\Cuota;

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
    public function notificacionCuotas()
    {
        $fechaActual=date('Y-m-d');
        $cuotasatra = Cuota::join('creditos', 'creditos.id', '=', 'cuotas.idcredito')
        ->join('personas', 'personas.id', '=', 'creditos.idcliente')
        ->select(
            
            'cuotas.id',
            'cuotas.fechapago',
            'cuotas.estado',
            'creditos.numeroprestamo')
        ->where('cuotas.estado','=',0)
        ->whereDate('cuotas.fechapago', '<', date('Y-m-d'))
        ->orderBy('cuotas.fechapago')
        ->get();

        return[
            'cuotasatrasadas'=>$cuotasatra
        ];


    }
}
