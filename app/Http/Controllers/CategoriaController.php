<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller{


    public function index(){
        $categoria = categoria::all();
        return view('layouts.categoria.index', compact('categoria'));
    }
    public function create(){
        $categoria = categoria::all();
        return view('layouts.categoria.index', compact('categoria'));
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'nombre' => 'required|max:255', // Valida que sea obligatorio, string, y de un tamaño razonable
            'descripcion' => 'nullable|max:255', // Campo opcional
        ], [
            'nombre.required' => 'Este campo es obligatorio.',
        ]);

        $categoria = new Categoria();

        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        Categoria::create($request->only(['nombre', 'descripcion']));
        return redirect()->route('categoria.index', compact('categoria'))->with('success', 'Categoria registrada exitosamente.');
    }

    public function show($id){
        $categoria = categoria::find($id);
        return view('layouts.categoria.show', compact('categoria'));
    }

    public function edit($id){
        $categoria = categoria::find($id);
        return view('layouts.categoria.edit', compact('categoria'));
    }

    public function update(Request $request, $id){
        
        $validatedData = $request->validate([
            'nombre' => 'required|max:255', // Valida que sea obligatorio, string, y de un tamaño razonable
            'descripcion' => 'nullable|max:255', // Campo opcional
        ], [
            'nombre.required' => 'Este campo es obligatorio.',
        ]);
        $categoria = categoria::find($id);
        $categoria->update($request->all());
        //return redirect()->route('almacen.index', compact('almacen');
        return redirect()->route('categoria.index')->with('success', 'Categoria actualizada exitosamente.');

    }
}
