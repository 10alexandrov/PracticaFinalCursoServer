<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = "productos";

    protected $primaryKey = 'id_product';

    protected $fillable = [
        'p_nombre',
        'p_categoria',
        'p_descripcion',
        'p_ancho',
        'p_longitud',
        'p_altura',
        'p_peso',
        'p_foto',
        'p_cantidad_almacen',
        'p_cantidad_entrega',
        'p_cantidad_reservado',
        'p_cantidad_enviado',
        'p_precio_compra',
        'p_precio_venta',
        'p_codigo',
        'fecha_ingreso',
    ];

}
