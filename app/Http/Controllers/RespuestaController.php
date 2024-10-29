<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Respuesta;
use App\Models\Pregunta;
use App\Models\Categoria;

class RespuestaController extends Controller
{
    public function index(Request $req)
    {
        $preguntas = Pregunta::with('categoria')->get();
        return view('content.form-layout.encuestaUsuario', compact('preguntas'));
    }

    public function storeResponse(Request $req)
    {
        // Validar los datos de la solicitud
        $req->validate([
            'id_encuesta' => 'required|integer', // Asegúrate de que se pase
            'id_pregunta' => 'required|exists:pregunta,id',
            'respuesta_cuanti' => 'nullable|integer|between:1,5',
            'respuesta_cuali' => 'nullable|string',
        ]);

        // Crear una nueva respuesta en la base de datos
        $respuesta = Respuesta::create([
            'id_encuesta' => $req->id_encuesta, // Usar el id_encuesta enviado
            'id_pregunta' => $req->id_pregunta,
            'respuesta_cuanti' => $req->respuesta_cuanti,
            'respuesta_cuali' => $req->respuesta_cuali,
        ]);

        // Devolver una respuesta JSON exitosa
        return response()->json(['message' => 'Respuesta guardada correctamente.', 'data' => $respuesta]);
    }

    public function list(Request $request)
    {
        // Obtener todas las categorías
        $categorias = Categoria::all();
        
        // Obtener la categoría seleccionada en el filtro
        $categoriaSeleccionada = $request->input('categoria');
        
        // Obtener respuestas filtradas por categoría (si se selecciona una)
        $respuestas = Respuesta::with(['pregunta' => function ($query) {
            $query->with('categoria');
        }])
        ->when($categoriaSeleccionada, function ($query) use ($categoriaSeleccionada) {
            $query->whereHas('pregunta.categoria', function ($q) use ($categoriaSeleccionada) {
                $q->where('id', $categoriaSeleccionada);
            });
        })
        ->get();

        // Pasar respuestas, categorías y categoría seleccionada a la vista
        return view('content.form-layout.respuestas', compact('respuestas', 'categorias', 'categoriaSeleccionada'));
    }

    
}
