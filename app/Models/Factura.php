<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $primaryKey = 'factura_id';

    protected $fillable = ['f_id_cliente', 'f_tipo', 'f_aceptado'];
}
