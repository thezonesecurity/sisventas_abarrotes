<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Psy\VarDumper\Presenter;

class Caracteristica extends Model
{
    use HasFactory;
    protected $table = 'sistemaventas.caracteristicas';

    protected $fillable = ['id', 'nombre','descripcion','estado' ];

    protected $dates = ['created_at','updated_at'];

    public function categoria(){
        return $this->hasOne(Categoria::class, 'caracteristica_id');
    }
    public function marca(){
        return $this->hasOne(Marca::class, 'caracteristica_id');
    }
    public function presentacion(){
        return $this->hasOne(Presentacion::class, 'caracteristica_id');
    }
   
}
