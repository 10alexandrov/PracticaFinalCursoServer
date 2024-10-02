<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;

class Producto extends Model
{
    use HasFactory;
    protected $table = "productos";

    protected $primaryKey = 'product_id';

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
        'p_nombre_categoria',
    ];

    public function categoria () {
        return $this->belongsTo(Categoria::class, 'p_categoria', 'id_categoria');
    }

    public function mercancias(){
        return $this->hasMany(Mercancia::class, 'product_id', 'm_id_productos');
    }

}
