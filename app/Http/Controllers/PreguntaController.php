<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pregunta;
use App\Models\Categoria;

class PreguntaController extends Controller
{
    public function index(Request $req)
    {
        // Busca la pregunta si existe o crea una nueva
        $pregunta = $req->id ? Pregunta::find($req->id) : new Pregunta();

        // Obtiene todas las categorías
        $categorias = Categoria::all();

        // Pasa la pregunta y las categorías a la vista
        return view('content.form-layout.pregunta', compact('pregunta', 'categorias'));
    }

    public function store(Request $req)
    {
        $req->validate([
            'id_categoria' => 'required|exists:categoria,id', // Validación de id_categoria
            'texto' => 'required|string',          // Validación de texto
            'tipo' => 'required|string|max:50',    // Validación de tipo
        ]);

        if($req->id){
            $pregunta = Pregunta::find($req->id);
        }else{
            $pregunta = new Pregunta();
        }

        $pregunta->texto = $req->texto;           // Guardar texto
        $pregunta->tipo = $req->tipo;             // Guardar tipo
        $pregunta->id_categoria = $req->id_categoria; // Guardar id_categoria
        $pregunta->save(); // Insertar o actualizar
        return redirect()->route('preguntas.lista');
    }

    public function list()
    {
        $preguntas = Pregunta::all();
        return view('content.form-layout.preguntas', compact('preguntas'));
    }

    public function delete($id)
    {
        $pregunta = Pregunta::find($id);
        $pregunta->delete();
        return redirect()->route('preguntas.lista');
    }

}
