<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credito extends Model
{
    //
    protected $fillable =[
        'idcliente',
        'idusuario',
        'numeroprestamo',
        'idkiva',
        'montodesembolsado',
        'fechadesembolso',
        'numerocuotas',
        'tipocambio',
        'tasa',
        'estado',
        'periodo'
    ];
//usuario que ha registrado el credito
    public function usuario(){
        return  $this->belongsTo('App\User');
    }
//cliente que saco el credito
    public function cliente(){
        return  $this->belongsTo('App\Cliente');
    }

}
