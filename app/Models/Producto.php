<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
     //protected $table = 'NombreSCHEMA.NombreTABLA';
     protected $table = 'sistemaventas.productos';

     protected $fillable = ['id','codigo','nombre','stock','descripcion','fecha_vencimineto'
     ,'imagen_path','estado','marca_id', 'presentacion_id'];
 
     protected $dates = ['created_at','updated_at'];

    public function compras(){//muchos a muchos tabla COMPRA-PRODUCTO
        return $this->belongsToMany(Compra::class)->withTimestamps()
          ->withPivot('cantidad','precio_compra','precio_venta');
    }
    public function ventas(){//muchos a muchos tabla PRODUCTO-VENTA
        return $this->belongsToMany(Venta::class)->withTimestamps()
          ->withPivot('cantidad','precio_venta','descuento');
    }
    public function categorias(){//muchos a muchos tabla CATEGORIA-PRODUCTO
        return $this->belongsToMany(Categoria::class)->withTimestamps();
    }
    public function marca(){
        return $this->belongsTo(Marca::class, 'marca_id');
    }
    public function presentacion(){
        return $this->belongsTo(Presentacion::class, 'presentacion_id');
    }
}
