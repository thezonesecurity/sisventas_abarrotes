<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;
    protected $table = 'sistemaventas.documentos';

    protected $fillable = ['id', 'tipo_documento','nro_documento', 'estado'];
    protected $dates = ['created_at','updated_at'];
    
    public function persona(){
        return $this->hasOne(Persona::class, 'documento_id');
    }
}
