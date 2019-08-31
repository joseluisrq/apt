<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Credito;
use App\Cuota;

class CreditoController extends Controller
{
    //
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar==''){
            $creditos = Credito::join('clientes','creditos.idcliente','=','clientes.id')
            ->join('personas','clientes.id','=','personas.id')
            ->join('users','creditos.idusuario','=','users.id')
            ->select(
                'creditos.id', 
                'creditos.numeroprestamo',
                'creditos.idkiva',
                 'creditos.montodesembolsado',
                'creditos.fechadesembolso',
                'creditos.numerocuotas',
                'creditos.tipocambio',
                'creditos.tasa',
                'creditos.estado',
                'creditos.periodo',
                'personas.nombre',
                'personas.apellidopaterno',
                'personas.apellidomaterno','users.usuario')
            ->orderBy('creditos.id', 'desc')->paginate(3);
        }
        else{
            $creditos = Credito::join('clientes','creditos.idcliente','=','clientes.id')
            ->join('personas','clientes.id','=','personas.id')
            ->join('users','creditos.idusuario','=','users.id')
            ->select(
                'creditos.id', 
                'creditos.numeroprestamo',
                'creditos.idkiva',
                'creditos.montodesembolsado',
                'creditos.fechadesembolso',
                'creditos.numerocuotas',
                'creditos.tipocambio',
                'creditos.tasa',
                'creditos.estado',
                'creditos.periodo',
                'personas.nombre',
                'personas.apellidopaterno',
                'personas.apellidomaterno','users.usuario')
            ->where('creditos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('creditos.id', 'desc')->paginate(3);
        }
         
        return [
            'pagination' => [
                'total'        => $creditos->total(),
                'current_page' => $creditos->currentPage(),
                'per_page'     => $creditos->perPage(),
                'last_page'    => $creditos->lastPage(),
                'from'         => $creditos->firstItem(),
                'to'           => $creditos->lastItem(),
            ],
            'creditos' => $creditos
        ];
    }
    public function obtenerCabecera(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
        $credito = Credito::join('clientes','creditos.idcliente','=','clientes.id')
        ->join('personas','clientes.id','=','personas.id')
        ->join('users','creditos.idusuario','=','users.id')
        ->select(
            'creditos.id', 
            'creditos.numeroprestamo',
            'creditos.idkiva',
            'creditos.montodesembolsado',
            'creditos.fechadesembolso',
            'creditos.numerocuotas',
            'creditos.tipocambio',
            'creditos.tasa',
            'creditos.estado',
            'creditos.periodo',
            'personas.nombre',
            'users.usuario')
        ->where('creditos.id','=',$id)
        ->orderBy('creditos.id', 'desc')->take(1)->get(); //obtendo el registro que coincide
         
        return ['credito' => $credito];
    }
    public function obtenerCuotas(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
        $cuota = Cuota::join('users','cuotas.idusuario','=','users.id')
        ->select(
            'cuotas.fechapago',
            'cuotas.fechacancelacion',
            'cuotas.saldopendiente',
            'cuotas.monto',
            'cuotas.otroscostos',
            'cuotas.descripcion',
            'cuotas.estado',
            'users.usuario')
        ->where('cuotas.idcredito','=',$id)
        ->orderBy('cuotas.id', 'desc')->get();
         
        return ['cuota' => $cuota];
    }
 
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
           
 
            $credito = new Credito();
            
            $credito->idcliente = $request->idcliente;
            $credito->idusuario = \Auth::user()->id;
            $credito->numeroprestamo = $request->numeroprestamo;
            $credito->idkiva = $request->idkiva;
            $credito->montodesembolsado = $request->montodesembolsado;
            $credito->fechadesembolso = $request->fechadesembolso; 
            $credito->numerocuotas = $request->numerocuotas; //cantidad de cuiotas
            $credito->tipocambio = $request->tipocambio; //de dolares a soles
            $credito->tasa = $request->tasa;
            $credito->estado = '1'; //Credito activo /2 credito inactivo //3 credito pagado completado
            $credito->periodo = $request->periodo; //1mensual/2bimensual/3trimestral/6semmestral/12anual
          
            $credito->save();
 
            $cuotas = $request->data;//Array de cuotas
            //Recorro todos los elementosq que me han enviado
 
            foreach($cuotas as $ep=>$cuot)
            {
                $cuota = new Cuota();
                $mytime= Carbon::now('America/Lima');

                $cuota->idcredito = $credito->id;
                $cuota->idusuario=\Auth::user()->id;
                $cuota->fechapago = $cuot['fechapago'];
                $cuota->fechacancelacion =$mytime->toDateString();
                $cuota->saldopendiente =  $cuot['saldopendiente']; //$cuot['fechacancelacion'];
                $cuota->monto = $cuot['monto']; //$cuot['fechacancelacion'];   
                $cuota->otroscostos =  $cuot['otroscostos'];; //$cuot['fechacancelacion'];     
                $cuota->descripcion =  $cuot['descripcion']; //$cuot['fechacancelacion']; 
                $cuota->estado = '0'; //0 por pagar //1 pagado 
                             
                $cuota->save();
            }          
 
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }
 
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $cuota = Credito::findOrFail($request->id);
        $cuota->estado = '2'; //anulado
        $cuota->save();
    }
}
