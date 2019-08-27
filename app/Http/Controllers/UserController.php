<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Persona;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    //
    public function index(Request $request)
    {
      if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar==''){
            $personas = User::join('personas','users.id','=','personas.id')
            ->join('roles','users.idrol','=','roles.id')
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
                'users.usuario',
                'users.password',
                'users.condicion',
                'users.idrol',
                'roles.nombre as rol')
            ->orderBy('personas.id', 'desc')->paginate(3);
        }
        else{
            $personas = User::join('personas','users.id','=','personas.id')
            ->join('roles','users.idrol','=','roles.id')
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
                'users.usuario',
                'users.password',
                'users.condicion',
                'users.idrol',
                'roles.nombre as rol')           
            ->where('personas.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('personas.id', 'desc')->paginate(3);
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
            DB::beginTransaction();
            $persona = new Persona();
            $persona->dni = $request->dni;
            $persona->nombre = $request->nombre;
            $persona->apellidopaterno = $request->apellidopaterno;
            $persona->apellidomaterno = $request->apellidomaterno;
            $persona->fechanacimiento = $request->fechanacimiento;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->email = $request->email;
            $persona->save();
 
            $user = new User();
            $user->usuario = $request->usuario;
            $user->password = bcrypt( $request->password);//encriptado
            $user->condicion = '1';
            $user->idrol = $request->idrol;          
 
            //tomamos la persona insertada yy la usamos de id del usuario
            $user->id = $persona->id;

            $user->save();
 
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
 
            //Buscar primero el proveedor a modificar
            $user = User::findOrFail($request->id);
 
            $persona = Persona::findOrFail($user->id);
 
            $persona->dni = $request->dni;
            $persona->nombre = $request->nombre;
            $persona->apellidopaterno = $request->apellidopaterno;
            $persona->apellidomaterno = $request->apellidomaterno;
            $persona->fechanacimiento = $request->fechanacimiento;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->email = $request->email;
            $persona->save();
 
             
            $user->usuario = $request->usuario;
            $user->password = bcrypt( $request->password);
            $user->condicion = '1';
            $user->idrol = $request->idrol;
            $user->save();
 
 
            DB::commit();
 
        } catch (Exception $e){
            DB::rollBack();
        }
 
    }
 
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condicion = '0';
        $user->save();
    }
 
    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condicion = '1';
        $user->save();
    }
}
