<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Factura;

class Usuario extends Authenticatable implements JWTSubject
{
    use HasFactory;
    protected $table = "usuarios";

    // Especifica la clave primaria de la tabla
    protected $primaryKey = 'usuario_id';

    protected $fillable =['u_nombre', 'u_login', 'u_password', 'u_role', 'u_active'];

    protected $hidden = [
        'u_password', 'remember_token',
    ];

    public function factura () {
        return $this->hasMeny(Factura::class);
    }

     // Method de JWTSubject

     public function getJWTIdentifier()
     {
         return $this->getKey();
     }

     public function getJWTCustomClaims()
     {
         return [];
     }

     public function getAuthPassword () {
        return $this -> u_password;
     }

     public function username() {
        return 'u_login';
    }

     public function facturasClient(){
        return $this->hasMany(Factura::class, 'usuario_id', 'f_id_cliente');
    }

    public function facturasResponsable(){
        return $this->hasMany(Factura::class, 'usuario_id', 'f_id_responsable');
    }

}

