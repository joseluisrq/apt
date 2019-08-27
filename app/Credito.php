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


}
