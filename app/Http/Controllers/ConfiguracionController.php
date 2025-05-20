<?php

namespace App\Http\Controllers;
use App\Models\Color;

use Illuminate\Http\Request;


class ConfiguracionController extends Controller
{
    public function index(){
        $colores = Color::all();
        return view('layouts.configuracion.configuracion', compact('colores'));
    }

    public function guardarColor(Request $request){
    $request->validate([
        'nombreColor' => 'required|string|max:255',
        'codigoHexa' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
    ]);

    Color::create([
        'nombreColor' => $request->input('nombreColor'),
        'codigoHexa' => $request->input('codigoHexa'),
    ]);

    return redirect()->route('configuracion.index')->with('success', 'Color registrado correctamente.');
}


public function eliminarColor($id)
{
    $color = Color::findOrFail($id);

    // Opcional: aquí podrías remover la relación con productos si existe.

    $color->delete();

    return redirect()->route('configuracion.index')->with('success', 'Color eliminado correctamente.');
}

}


