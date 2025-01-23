<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    //protected $table = 'NombreSCHEMA.NombreTABLA';
    protected $table = 'sistemaventas.personas';

    protected $fillable = ['id','nombres','apellidos','ci','razon_social','direccion',
       'tipo_persona','estado', 'documento_id'];

    protected $dates = ['created_at','updated_at'];
    
    public function documento(){
        return $this->belongsTo(Documento::class, 'documento_id');
    }
    public function proveedor(){
        return $this->hasOne(Proveedor::class, 'persona_id');
    }
    public function cliente(){
        return $this->hasOne(Cliente::class, 'persona_id');
    }
}
