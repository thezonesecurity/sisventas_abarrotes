<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
     //protected $table = 'NombreSCHEMA.NombreTABLA';
     protected $table = 'sistemaventas.compras';

     protected $fillable = ['id','fecha_hora','impuesto','total','nro_comprobante','descripcion',
        'estado','comprobante_id', 'proveedor_id'];
 
     protected $dates = ['created_at','updated_at'];

    public function proveedor(){
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }
    public function comprobante(){
        return $this->belongsTo(Comprobante::class, 'comprobante_id');
    }
    public function productos(){//muchos a muchos tabla COMPRA-PRODUCTO
        return $this->belongsToMany(Producto::class)->withTimestamps()
          ->withPivot('cantidad','precio_compra','precio_venta');
    }
}
