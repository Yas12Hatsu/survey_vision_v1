<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    use HasFactory;
    protected $table = "pregunta";

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public function respuesta()
    {
        return $this->hasMany(Respuesta::class, 'id_pregunta');
    }
}
