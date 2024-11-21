<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;

class AlmacenController extends Controller{

    public function index(Request $request) {
        $almacen = Almacen::all();
        return view('layouts.almacen.index', compact('almacen'));
    }
    public function create(){
        $almacen = Almacen::all();
        return view('layouts.almacen.index', compact('almacen'));
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'nombre' => 'required|max:255', // Valida que sea obligatorio, string, y de un tamaño razonable
            'direccion' => 'nullable|max:255', // Campo opcional
            'observaciones' => 'nullable|max:1000', // Observaciones más largas pero opcionales
        ]);

        $almacen = new Almacen();

        $almacen->nombre = $request->nombre;
        $almacen->direccion = $request->direccion;
        $almacen->observaciones = $request->observaciones;
        // $almacen->save();
        // Si pasa la validación, guarda el registro
        Almacen::create($request->only(['nombre', 'direccion', 'observaciones']));
        // return redirect()->route('almacen.index');
        return redirect()->route('almacen.index')->with('success', 'Almacén registrado exitosamente.');
    }

    public function show($id){
        $almacen = Almacen::find($id);
        return view('layouts.almacen.show', compact('almacen'));
    }

    public function update(Request $request, $id){
        $almacen = Almacen::find($id);
        $almacen->update($request->all());
        return redirect()->route('almacen.index', compact('almacen'));
    }
    public function edit($id){
        $almacen = Almacen::find($id);
        return redirect()->route('almacen.edit', compact('almacen'));
    }
}
