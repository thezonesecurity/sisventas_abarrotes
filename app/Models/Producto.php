<?php

namespace App\Models;

use Illuminate\Contracts\Cache\Store;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Producto extends Model
{
    use HasFactory;
     //protected $table = 'NombreSCHEMA.NombreTABLA';
     protected $table = 'sistemaventas.productos';

     protected $fillable = ['id','codigo','nombre','stock','descripcion','fecha_vencimiento'
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

    ///////////////////////////////////////////////////

    public function productoscat(){//de uno  a muchos tabla COMPRA-PRODUCTO
        return $this->hasMany(Categoria_producto::class,'producto_id');
    }

    ////////////////////////////////////////////////////
    public function categorias(){//muchos a muchos tabla CATEGORIA-PRODUCTO
        return $this->belongsToMany(Categoria::class,'sistemaventas.categoria_producto','producto_id','categoria_id')->withTimestamps(); ///,'categoria_producto','producto_id','categoria_id')->withTimestamps();
    }

    public function marca(){
        return $this->belongsTo(Marca::class, 'marca_id');
    }
    public function presentacion(){
        return $this->belongsTo(Presentacion::class, 'presentacion_id');
    }
    //funcion para verificar si existe una imagen y guardarlo en la carpeta public
    public function hanbleUloadImage($image){
        $file = $image;
        $name = time().$file->getClientOriginalName();
        //$file->move(public_path().'/img/productos/', $name);
        Storage::putFileAs('/public/productos/',$file,$name,'public');

        return $name;
    }
}
