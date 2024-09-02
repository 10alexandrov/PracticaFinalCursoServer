<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;

class Categoria extends Model
{
    protected $table = "categorias";

    protected $primaryKey = 'id_categoria';

    protected $fillable = [
        'id_categoria',
        'c_nombre',
    ];

    public function productos(){
        return $this->hasMany(Producto::class, 'p_categoria', 'id_categoria');
    }
}
