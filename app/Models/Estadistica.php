<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estadistica extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [

        'id',
        'e_fecha',
        'e_suma_restos',
        'e_volumen_restos',
        'e_suma_compras_hoy',
        'e_suma_ventas_hoy',
        'e_suma_compras_mes',
        'e_suma_ventas_mes',
        'e_beneficios_hoy',
        'e_beneficios_mes'];
}
