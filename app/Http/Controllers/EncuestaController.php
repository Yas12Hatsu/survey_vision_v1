<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Encuesta;

class EncuestaController extends Controller
{
    public function index(Request $req)
    {
        if($req->id){
            $encuesta = Encuesta::find($req->id);
        }else{
            $encuesta = new Encuesta();
        }

        return view('content.form-layout.encuesta', compact('encuesta'));
    }

    public function store(Request $req)
    {
        $req->validate([
            'fecha_creacion' => 'required|date',
            'id_restaurante' => 'nullable|integer',
            'comentarios' => 'nullable|string',
        ]);

        if($req->id !=0){
            $encuesta= Encuesta::find($req->id);
        }else{
            $encuesta = new Encuesta();
        }

        $encuesta->fecha_creacion = $req->fecha_creacion;
        $encuesta->id_restaurante = $req->id_restaurante;
        $encuesta->comentarios = $req->comentarios;
        $encuesta->save();//insert
        return redirect()->route('encuestas.lista');
    }

    public function list()
    {
        $encuestas = Encuesta::all();
        return view('content.form-layout.encuestas', compact('encuestas'));
    }

    public function delete($id){
        $encuesta = Encuesta::find($id);
        $encuesta->delete();
        return redirect()->route('encuestas.lista');
    }
}
