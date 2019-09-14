<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\CreditoBitacora;
use App\Cuota;
use App\Persona;


class CreditoBitacoraController extends Controller
{
    
    public function cambiosRegistrados(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
         $creditobitacora = CreditoBitacora::join('creditos','creditos_bitacora.idcredito','=','creditos.id')
         ->join('users','creditos.idusuario','=','users.id')
         ->join('personas','users.id','=','personas.id')
        ->select(
            'creditos_bitacora.id', 

            'creditos_bitacora.numeroprestamo_n',
            'creditos_bitacora.numeroprestamo_v',

            'creditos_bitacora.idkiva_n',
            'creditos_bitacora.idkiva_v',

            'creditos_bitacora.idcliente_n',
            'creditos_bitacora.idcliente_v',

            'creditos_bitacora.montodesembolsado_n',
            'creditos_bitacora.montodesembolsado_v',

            'creditos_bitacora.fechadesembolso_n',
            'creditos_bitacora.fechadesembolso_v',

            'creditos_bitacora.numerocuotas_n',
            'creditos_bitacora.numerocuotas_v',

            'creditos_bitacora.tipocambio_n',
            'creditos_bitacora.tipocambio_v',
            
            'creditos_bitacora.tasa_n',
            'creditos_bitacora.tasa_v',

            'creditos_bitacora.estado_n',
            'creditos_bitacora.estado_v',

            'creditos_bitacora.periodo_n',
            'creditos_bitacora.periodo_v',

            'creditos_bitacora.idusuario_n',
            'creditos_bitacora.idusuario_v',

            'creditos.numeroprestamo',

            'personas.nombre',
            'personas.apellidopaterno',

            'creditos_bitacora.condicion',
            'creditos_bitacora.fechacambio',
            
                      
            )
        ->where('creditos_bitacora.idcredito','=',$id)
        ->orderBy('creditos_bitacora.id', 'asc')->get();
         
        return ['creditosbit' => $creditobitacora];

    }

}
