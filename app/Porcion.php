<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Porcion extends Model
{
    //
    protected $table='porciones';
    protected $fillable =[
        'idusuario',
        'fechapago',
        'fechacancelacion',
        'monto',
        'otroscostos',
        'descripcion',
        'estado',
    ];

    public function usuario(){
        return  $this->belongsTo('App\User');
    }
}
