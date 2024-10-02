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
        $request->validate([
            'id_encuesta' => 'required|exists:encuestas,id',
            'id_pregunta' => 'required|exists:preguntas,id',
            'respuesta_cuanti' => 'nullable|integer|min:1|max:5',
            'respuesta_cuali' => 'nullable|string',
        ]);

        $respuesta = Respuesta::create($request->all());
        return response()->json($respuesta, 201);
    }

    /*public function create()
    {
        $surveys = Survey::all();
        $questions = Question::all();
        return view('answers.create', compact('surveys', 'questions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_encuesta' => 'required|exists:surveys,id',
            'id_pregunta' => 'required|exists:questions,id',
            'respuesta_cuanti' => 'nullable|integer|between:1,5',
            'respuesta_cuali' => 'nullable|string',
        ]);

        Answer::create($request->all());

        return redirect()->route('answers.index')->with('success', 'Answer created successfully.');
    }

    public function show(Answer $answer)
    {
        return view('answers.show', compact('answer'));
    }

    public function edit(Answer $answer)
    {
        $surveys = Survey::all();
        $questions = Question::all();
        return view('answers.edit', compact('answer', 'surveys', 'questions'));
    }

    public function update(Request $request, Answer $answer)
    {
        $request->validate([
            'id_encuesta' => 'required|exists:surveys,id',
            'id_pregunta' => 'required|exists:questions,id',
            'respuesta_cuanti' => 'nullable|integer|between:1,5',
            'respuesta_cuali' => 'nullable|string',
        ]);

        $answer->update($request->all());

        return redirect()->route('answers.index')->with('success', 'Answer updated successfully.');
    }

    public function destroy(Answer $answer)
    {
        $answer->delete();

        return redirect()->route('answers.index')->with('success', 'Answer deleted successfully.');
    }*/
}
