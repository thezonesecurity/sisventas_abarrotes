<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria_producto extends Model
{
    use HasFactory;
    protected $table = 'sistemaventas.categoria_producto';

    protected $fillable = ['id','producto_id', 'categoria_id'];

    public function productoscatprod(){//muchos a muchos tabla CATEGORIA-PRODUCTO
        return $this->belongsToMany(Producto::class,'producto_id');
    }

    public function categoriascatprod(){//muchos a muchos tabla CATEGORIA-PRODUCTO
        return $this->belongsToMany(Categoria::class,'categoria_id');
    }
}
