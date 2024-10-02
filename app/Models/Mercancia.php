<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Factura;
use App\Models\Producto;

class Mercancia extends Model
{
    use HasFactory;

    public $timestamps = false;


    protected $fillable = [
        'm_id_facturas',
        'm_id_productos',
        'm_cantidad_pedida',
        'm_cantidad_recogida',
        'm_suma_pedida',
        'm_suma_recogida',
        'm_aceptado'
    ];

    public function factura () {
        return $this->belongsTo(Factura::class, 'm_id_facturas', 'factura_id');
    }

    public function producto () {
        return $this->belongsTo(Producto::class, 'm_id_productos', 'product_id');
    }
}
