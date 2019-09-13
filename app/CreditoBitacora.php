<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditoBitacora extends Model
{
    //
    protected $table = 'creditos_bitacora';
    protected $fillable =[
        'idcredito',
        'idcliente_v',
        'idcliente_n',
        'idusuario_v',
        'idusuario_n',
        'numeroprestamo_v',
        'numeroprestamo_n',
        'idkiva_v',
        'idkiva_n',
        'montodesembolsado_v',
        'montodesembolsado_n',
        'fechadesembolso_v',
        'fechadesembolso_n',
        'numerocuotas_v',
        'numerocuotas_n',
        'tipocambio_v',
        'tipocambio_n',
        'tasa_v',
        'tasa_n',
        'estado_v',
        'estado_n',
        'periodo_n',
        'periodo_v',
        'condicion'
    ];
/*usuario que ha registrado el credito
    public function usuario(){
        return  $this->belongsTo('App\User');
    }
//cliente que saco el credito
    public function cliente(){
        return  $this->belongsTo('App\Cliente');
    }*/
}
