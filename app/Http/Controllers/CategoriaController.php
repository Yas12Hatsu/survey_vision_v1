<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function index(Request $req)
    {
        if($req->id){
            $categoria = Categoria::find($req->id);
        }else{
            $categoria = new Categoria();
        }

        return view('content.form-layout.categoria', compact('categoria'));
    }

    public function store(Request $req)
    {
        $req->validate([
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
        ]);

        if($req->id){
            $categoria = Categoria::find($req->id);
        }else{
            $categoria = new Categoria();
        }

        $categoria->nombre = $req->nombre;
        $categoria->descripcion = $req->descripcion;
        $categoria->save(); // insert
        return redirect()->route('categorias.lista');
    }

    public function list()
    {
        $categorias = Categoria::all();
        return view('content.form-layout.categorias', compact('categorias'));
    }

    public function delete($id)
    {
        $categoria = Categoria::find($id);
        $categoria->delete();
        return redirect()->route('categorias.lista');
    }
}
