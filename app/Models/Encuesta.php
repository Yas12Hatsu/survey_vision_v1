<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    use HasFactory;
    protected $table = "encuesta";
    /*protected $fillable = ['fecha_creacion', 'id_restaurante', 'comentarios'];

    public function respuesta()
    {
        return $this->hasMany(Respuesta::class, 'id_encuesta');
    }*/

}
