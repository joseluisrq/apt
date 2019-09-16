<?php

namespace App\Http\Controllers;

use App\Credito;
use App\Cuota;
use App\Porcion;
use App\Persona;
use App\Cliente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CuotaController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $fechahoy = Carbon::now('America/Lima');

        $dni = $request['dni'];

        if($dni != null)
        {
            $cuotas = Cuota::join('creditos', 'creditos.id', '=', 'cuotas.idcredito')
            ->join('personas', 'personas.id', '=', 'creditos.idcliente')
            ->select(
                'creditos.idkiva',
                'creditos.numeroprestamo',
                'creditos.tipocambio',
                'creditos.fechakiva',
                'creditos.tasa',
                'creditos.numerocuotas',
                'creditos.montodesembolsado',
                'cuotas.id',
                'cuotas.numerocuota',
                'cuotas.fechacancelacion',
                'cuotas.fechapago',
                'cuotas.monto',
                'cuotas.otroscostos',
                'cuotas.saldopendiente',
                'personas.nombre',
                'personas.apellidopaterno',
                'personas.apellidomaterno',
                'personas.dni'
            )
            ->where('personas.dni', '=',$dni)
            ->where('creditos.estado', '=', '1')//Buscar los créditos activos
            ->where('cuotas.estado', '=', '0')//Buscar las cuotas que faltan pagar
            ->orderby('fechapago', 'ASC')//Buscar las cuotas que faltan pagar
            ->limit(1)//Solo se obtiene la cuota que debe pagar
            ->get();
        }else{
            $cuotas = Cuota::join('creditos', 'creditos.id', '=', 'cuotas.idcredito')
                ->join('personas', 'personas.id', '=', 'creditos.idcliente')
                ->select(
                    'creditos.idkiva',
                    'creditos.tipocambio',
                    'creditos.numeroprestamo',
                    'creditos.montodesembolsado',
                    'creditos.numerocuotas',
                    'creditos.tasa',
                    'cuotas.id',
                    'cuotas.numerocuota',
                    'cuotas.fechacancelacion',
                    'cuotas.fechapago',
                    'cuotas.monto',
                    'cuotas.otroscostos',
                    'cuotas.saldopendiente',
                    'personas.nombre',
                    'personas.apellidopaterno',
                    'personas.apellidomaterno',
                    'personas.dni'
                )
                ->where('cuotas.estado', '=', '0')
                ->get();
        }

        return [
            'cuotas' => $cuotas,
            'fechahoy' =>  $fechahoy
        ];
    }

    public function cuotaPagoCliente(Request $request)//Este método retorna la cuota que el cliente debe pagar
    {
        if (!$request->ajax()) return redirect('/');

        $fechahoy = Carbon::now('America/Lima');



        return [
            'cuotas' => $cuotas,
            'fechahoy' =>  $fechahoy
        ];
    }

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
                $cuota->estado = '0'; //$cuot['fechacancelacion'];        
                             
                $cuota->save();
            }          
 
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function update(Request $request)
    {        
        if (!$request->ajax()) return redirect('/');
         
        try{
            DB::beginTransaction();

            $cuota = Cuota::findOrFail($request->id);

            $descripcion = $request->descripcion;
           
            if($descripcion == null) $descripcion = "Cuota pagada";

            $cuota->descripcion = $descripcion;
            $cuota->otroscostos = $request->otrospagos;
            $cuota->fechacancelacion = Carbon::now('America/Lima');
            $cuota->estado = "1";
            $cuota->save();

            $idcredito = $cuota->idcredito;
            //Verificar que todas las cuotas del crédito se hayan pagado
            $cuotas = Cuota::join('creditos', 'creditos.id', '=', 'cuotas.idcredito')
            ->select(
                'cuotas.id'
            )
            ->where('cuotas.estado', '=', '0')
            ->where('creditos.id', '=', $idcredito)
            ->get();

            if(sizeof($cuotas) == 0){//En este caso ya se pagaron todas las cuotas
                $credito = Credito::findOrFail($idcredito);

                $credito->estado = "2";//Crédito finalizado
                $credito->save();

                $idpersona = $request->idpersona;
                $cliente = Cliente::findOrFail($idpersona);
                $cliente->estadocredito = "0";//Crédito finalizado
                $cliente->save();
            }


            DB::commit();
 
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function registrarPorcionPago(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            //Crear el registro de porción de cuota
            $mytime = Carbon::now('America/Lima');
 
            $porcion = new Porcion();
            
            $porcion->id = $request->id;
            $porcion->idusuario = \Auth::user()->id;
            $porcion->fechapago = $mytime;
            $porcion->fechacancelacion = $mytime;
            $porcion->monto = $request->monto;
            $porcion->otroscostos = $request->otroscostos;
            $porcion->descripcion = $request->descripcion;
            $porcion->estado = "1";//Como se paga el mismo día de su creación, el estado es PAGADO
            $porcion->save();

            //Actualizar el monto de la cuota de la cual solo se ha pagado una porción
            $cuota = Cuota::findOrFail($request->id);

            $cuota->monto = $cuota->monto - $request->monto;
            $cuota->estado = "0";//La cuota aún está pendiente de pago
            $cuota->save();

            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }
}
