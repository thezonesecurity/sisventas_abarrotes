<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'sistemaventas.clientes';

    protected $fillable = ['id', 'persona_id'];

    protected $dates = ['created_at','updated_at'];

    public function persona(){
        return $this->belongsTo(Persona::class, 'persona_id');
    }
    public function ventas(){
        return $this->hasMany(Venta::class, 'cliente_id');
    }
}
