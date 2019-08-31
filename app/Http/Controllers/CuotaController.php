<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Cuota;

class CuotaController extends Controller
{
    //
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $mytime= Carbon::now('America/Lima');
 
            $credito = new Credito();
            
            $credito->idcredito = $request->idcredito;
            $credito->idusuario = \Auth::user()->id;
            $credito->fechapago = $request->fechapago;
            $credito->fechacancelacion = $mytime->toDateString();
            $credito->montodesembolsado = $request->montodesembolsado;
            $credito->saldopendiente = $request->saldopendiente;
            $credito->monto = $request->monto;
            $credito->otroscostos = $request->otroscostos;
            $credito->descripcion = $request->descripcion;
            $credito->estado = $request->estado;
          
          
            $credito->save();
            $cuotas = $request->data;//Array de cuotas
            //Recorro todos los elementos
 
            foreach($cuotas as $ep=>$cuot)
            {
                $cuota = new Cuota();
                
                $cuota->idcredito = $credito->id;
                $cuota->idusuario=\Auth::user()->id;
                $cuota->fechapago = '';
                $cuota->fechacancelacion = ''; //$cuot['fechacancelacion'];
                $cuota->saldopendiente = 0; //$cuot['fechacancelacion'];
                $cuota->monto = 0; //$cuot['fechacancelacion'];   
                $cuota->otroscostos = 0; //$cuot['fechacancelacion'];     
                $cuota->descripcion = 'Registro Nuevo'; //$cuot['fechacancelacion']; 
                $cuota->estado = '1'; //$cuot['fechacancelacion'];        
                             
                $cuota->save();
            }          
 
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }
}
