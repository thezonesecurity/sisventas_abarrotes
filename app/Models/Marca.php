<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $table = 'sistemaventas.marcas';

     protected $fillable = ['id', 'caracteristica_id'];
 
     protected $dates = ['created_at','updated_at'];

    public function productos(){
        return $this->hasMany(Producto::class, 'marca_id');
    }
    public function caracteristica(){
        return $this->belongsTo(Caracteristica::class,'caracteristica_id');
    }
}
