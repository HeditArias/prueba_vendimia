<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = 'detalle_ventas';
    protected $fillable = [
        'id_venta', 
        'id_articulo',
        'cantidad',
        'precio',
        'importe',
        'descuento'
    ];
}
