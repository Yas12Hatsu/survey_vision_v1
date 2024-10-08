<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Respuesta;

class RespuestaController extends Controller
{
    public function index()
    {
        $respuestas = Respuesta::all();
        return response()->json($respuestas);
    }

    public function storeAPI(Request $request)
    {
        dd($request->all()); // Esto detiene la ejecución y muestra los datos
        $request->validate([
            'id_encuesta' => 'required|exists:encuestas,id',
            'id_pregunta' => 'required|exists:preguntas,id',
            'respuesta_cuanti' => 'nullable|integer|min:1|max:5',
            'respuesta_cuali' => 'nullable|string',
        ]);

        $respuesta = Respuesta::create($request->all());
        return response()->json($respuesta, 201);
    }
}
