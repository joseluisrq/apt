<?php

namespace App\Exports;

use App\Credito;
use App\Cuota;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
//se Maatwebsite\Excel\Concerns\Exportable;
//use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
//use Maatwebsite\Excel\Concerns\FromView;

class CreditoExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;
    private $endDate;

   /* public function collection()
    {
        return Credito::all();
    }*/
    public function view(): View{
        $date = Carbon::now('America/Lima');
        //$date = $date->subMonth();
        $dateMes= $date->format('m');
        $dateAno= $date->format('Y');
   
        
        return view('excel.creditoexcel',[
           'cuotas'=>Cuota::join('creditos','idcredito','creditos.id')
           ->where('creditos.estado', '=', '1') //CREDITOS ACTIVOS
           ->where ('cuotas.estado', '=', '1')  //CUOTAS PAGADAS
           ->whereMonth('cuotas.fechapago', '<', $dateMes) //CUOTAS QUE SU FECHA ES EL MES PASADO
           ->whereYear('cuotas.fechapago', '=', $dateAno)   //ANO ACTUAL
           ->groupBy('cuotas.idcredito')                     //AGRUPAMOS POR CREDITO
           ->select(
                //'cuotas.fechapago',
              // 'creditos.numeroprestamo',
              // 'creditos.montodesembolsado',
               'cuotas.idcredito',
                DB::raw('SUM(cuotas.monto) as montosporcredito')

            )->get(),
            'creditos'=>Cuota::join('creditos','idcredito','creditos.id')
            ->where('creditos.estado', '=', '1') //CREDITOS ACTIVOS
            ->where ('cuotas.estado', '=', '1')  //CUOTAS PAGADAS
            ->whereMonth('cuotas.fechapago', '<', $dateMes) //CUOTAS QUE SU FECHA ES EL MES PASADO
            ->whereYear('cuotas.fechapago', '=', $dateAno)
            ->select(
                'creditos.montodesembolsado',
                'creditos.numeroprestamo',
                'creditos.id') 
            ->get()

        ]);
    }
}
