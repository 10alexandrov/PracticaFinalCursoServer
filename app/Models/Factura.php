<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuarios;

class Factura extends Model
{
    use HasFactory;

    protected $primaryKey = 'factura_id';

    protected $fillable = [
        'factura_id',
        'f_id_cliente',
        'f_tipo',
        'f_id_responsable',
        'f_aceptado',
        'f_fecha_tramitacion',
        'f_suma_tramitacion',
        'f_aceptado',
        'created_at'];


    public function usuarioCliente () {
        return $this->belongsTo(Usuario::class, 'f_id_cliente', 'usuario_id');
    }

    public function usuarioResponsable () {
        return $this->belongsTo(Osuario::class, 'f_id_responsable', 'usuario_id');
    }

    public function mercancias(){
        return $this->hasMany(Mercancia::class, 'factura_id', 'm_id_facturas');
    }
}
