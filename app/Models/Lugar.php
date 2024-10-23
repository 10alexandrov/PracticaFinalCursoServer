<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;

class Lugar extends Model
{
    use HasFactory;

    protected $table = "lugares";

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'lugar_estanteria',
        'lugar_column',
        'lugar_planta',
        'lugar_producto',
        'lugar_cantidad',
        'lugar_llenado'
    ];

    public function producto () {
        return $this->belongsTo(Producto::class, 'lugar_producto', 'product_id');
    }
}
