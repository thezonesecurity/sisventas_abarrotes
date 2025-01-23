<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{
    use HasFactory;
    protected $table = 'sistemaventas.comprobantes';

    protected $fillable = ['id', 'tipo_comprobante', 'estado'];

    protected $dates = ['created_at','updated_at'];
    
    public function compras(){
        return $this->hasMany(Compra::class, 'comprobante_id');
    }
    public function ventas(){
        return $this->hasMany(Venta::class, 'comprobante_id');
    }
}
