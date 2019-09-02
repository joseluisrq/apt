<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\Cliente;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar==''){
            $personas = Cliente::join('personas','clientes.id','=','personas.id')
            ->select(
            'personas.id',
            'personas.dni',
            'personas.nombre',
            'personas.apellidopaterno',
            'personas.apellidomaterno',
            'personas.fechanacimiento',
            'personas.direccion',
            'personas.telefono',
            'personas.email',
            'personas.estado as estado_per',
            'clientes.estado as estado_cli'
            )
            ->orderBy('personas.id', 'desc')->paginate(10);
        }
        else{
            $personas = Cliente::join('personas','clientes.id','=','personas.id')
            ->select(
                'personas.id',
                'personas.dni',
                'personas.nombre',
                'personas.apellidopaterno',
                'personas.apellidomaterno',
                'personas.fechanacimiento',
                'personas.direccion',
                'personas.telefono',
                'personas.email',
                'personas.estado as estado_per',
                'clientes.estado as estado_cli'
            )            
            ->where('personas.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('personas.id', 'desc')->paginate(10);
        }
         
 
        return [
            'pagination' => [
                'total'        => $personas->total(),
                'current_page' => $personas->currentPage(),
                'per_page'     => $personas->perPage(),
                'last_page'    => $personas->lastPage(),
                'from'         => $personas->firstItem(),
                'to'           => $personas->lastItem(),
            ],
            'personas' => $personas
        ];
    }
 
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
         
        try{
            DB::beginTransaction(); //utlizamos transaccion
            $persona = new Persona();
            $persona->dni = '7021545';//prueba no se esta registrando el dni
            $persona->nombre = $request->nombre;
            $persona->apellidopaterno = $request->apellidopaterno;
            $persona->apellidomaterno = $request->apellidomaterno;
           // $persona->fechanacimiento = $request->fechanacimiento;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->email = $request->email;
           // $persona->estado = $request->estado_per;
            $persona->save();
 
            $cliente = new Cliente();
            //$cliente->estado = $request->estado_cli;  
            $cliente->id = $persona->id;
            $cliente->save();
 
            DB::commit();
 
        } catch (Exception $e){
            DB::rollBack(); //DESACER TODO SI HUBIER ALAGUN ERROR
        }
 
         
         
    }
 
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
         
        try{
            DB::beginTransaction();
 
            //Buscar primero el proveedor a modificar
            $cliente = Cliente::findOrFail($request->id);
 
            $persona = Persona::findOrFail($cliente->id);//REALIZAMOS UNA BUSQUEDA CON EL ID DEL PROVEEDOR PARA BUSCAR EL 
            //persona porque son el mismo
 
            $persona->dni = $request->dni;
            $persona->nombre = $request->nombre;
            $persona->apellidopaterno = $request->apellidopaterno;
            $persona->apellidomaterno = $request->apellidomaterno;
            $persona->fechanacimiento = $request->fechanacimiento;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->email = $request->email;
            $persona->estado = $request->estado_per;
            $persona->save();
 
             
            $cliente->estado = $request->estado_cli;
            
            $cliente->save();
 
            DB::commit();
 
        } catch (Exception $e){
            DB::rollBack();
        }
 
    }

    public function selectCliente(Request $request){
        //if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;

        $clientes = Cliente::join('personas','clientes.id','=','personas.id')
        ->where('clientes.estadocredito', '=', '0') //cliente sin credito cambiar a 0
        ->where('clientes.estado', '=', '1') //cliente activo
        ->where('personas.dni', 'like', '%'. $filtro . '%')
       //->orWhere('personas.nombre', 'like', '%'. $filtro . '%')
       
        ->select('personas.id','personas.nombre','personas.apellidopaterno','personas.apellidomaterno','personas.dni','clientes.estadocredito')
        ->orderBy('personas.nombre', 'asc')->get();

        return ['clientes' => $clientes];
    }

  
}

