<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $table = 'sistemaventas.proveedores';

    protected $fillable = ['id', 'persona_id'];

    protected $dates = ['created_at','updated_at'];

    public function persona(){
        return $this->belongsTo(Persona::class, 'persona_id');
    }
    public function compras(){
        return $this->hasMany(Compra::class, 'proveedor_id');
    }
}
