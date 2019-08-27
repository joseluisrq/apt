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
                'personas.nombre','users.usuario')
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
                'personas.nombre','users.usuario')
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
            'ventas' => $creditos
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
 
            //$mytime= Carbon::now('America/Lima');
 
            $credito = new Credito();
            
            $credito->idcliente = $request->idcliente;
            $credito->idusuario = \Auth::user()->id;
            $credito->numeroprestamo = $request->numeroprestamo;
            $credito->idkiva = $request->idkiva;
            $credito->montodesembolsado = $request->montodesembolsado;
            $credito->fechadesembolso = $request->fechadesembolso;
            $credito->numerocuotas = $request->numerocuotas;
            $credito->tipocambio = $request->tipocambio;
            $credito->tasa = $request->tasa;
            $credito->estado = $request->estado;
            $credito->periodo = $request->periodo;
          
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
 
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $cuota = Credito::findOrFail($request->id);
        $cuota->estado = '2'; //anulado
        $cuota->save();
    }
}
