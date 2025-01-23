<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $table = 'sistemaventas.categorias';

     protected $fillable = ['id', 'caracteristica_id'];
 
     protected $dates = ['created_at','updated_at'];

     public function productos(){//muchos a muchos tabla CATEGORIA-PRODUCTO
        return $this->belongsToMany(Producto::class)->withTimestamps();
    }
    public function caracteristica(){
        return $this->belongsTo(Caracteristica::class,'caracteristica_id');
    }
}
