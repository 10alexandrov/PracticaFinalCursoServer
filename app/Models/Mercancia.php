<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->bellongsTo(Factura::class);
    }

    public function producto () {
        return $this->bellongsTo(Producto::class);
    }
}
