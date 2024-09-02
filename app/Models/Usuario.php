<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    protected $table = "usuarios";

    // Especifica la clave primaria de la tabla
    protected $primaryKey = 'usuario_id';

    protected $fillable =['u_nombre', 'u_login', 'u_password', 'u_role'];

    public function factura () {
        return $this->hasMeny(Factura::class);
    }

}

