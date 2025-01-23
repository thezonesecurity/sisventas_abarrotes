<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $table = 'sistemaventas.ventas';

    protected $fillable = ['id','fecha_hora','impuesto','total','nro_comprobante','descripcion',
       'estado','cliente_id','user_id', 'comprobante_id'];

    protected $dates = ['created_at','updated_at'];

    public function cliente(){
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function comprobante(){
        return $this->belongsTo(Comprobante::class, 'comprobante_id');
    }
    public function productos(){//muchos a muchos tabla PRODUCTO-VENTA
        return $this->belongsToMany(Producto::class)->withTimestamps()
          ->withPivot('cantidad','precio_venta','descuento');
    }
 //6:36
}
