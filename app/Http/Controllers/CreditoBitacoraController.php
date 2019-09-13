<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\CreditoBitacora;
use App\Cuota;


class CreditoBitacoraController extends Controller
{
    
    public function cambiosRegistrados(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
         $creditobitacora = CreditoBitacora::
        select(
            'creditos_bitacora.id', 
            'creditos_bitacora.idcliente_n',
            'creditos_bitacora.idcliente_v',
            'creditos_bitacora.condicion',
            'creditos_bitacora.fechacambio',
            
                      
            )
        ->where('creditos_bitacora.idcredito','=',$id)
        ->orderBy('creditos_bitacora.id', 'asc')->get();
         
        return ['creditosbit' => $creditobitacora];

    }

}
