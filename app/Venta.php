<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable =[
        'id_cliente', 
    	'enganche',
    	'bonificacion_enganche',
        'total',
        'ahorro',
        'pago_mensual',
        'plazo',
        'estado'
    ];
}
