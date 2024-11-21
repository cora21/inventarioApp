<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MetodoPago;
use Illuminate\Support\Facades\Storage;

class MetodoPagoController extends Controller{
    public function index(){
        $metPago = MetodoPago::all();
        return view('layouts.metodoPago.index', compact('metPago'));
    }
    public function create(){
        $metPago = MetodoPago::all();
        return view('layouts.metodo.index', compact('metPago'));
    }


    public function store(Request $request)
{
    // Validar los campos
    $request->validate([
        'nombreMetPago' => 'required|max:255',
        'imageMetodo' => 'image', // Verifica que el archivo sea una imagen
    ], [
        'nombreMetPago.required' => 'Este campo es obligatorio.',
        'imageMetodo.image' => 'Debe subir una imagen válida.',
    ]);

    // Subir la imagen y obtener la URL
    if ($request->hasFile('imageMetodo')) {
        $imagenes = $request->file('imageMetodo')->store('public/imagenes');
        $url = Storage::url($imagenes); // Genera la URL accesible públicamente
    } else {
        $url = null; // En caso de que no se suba una imagen
    }

    // Crear un nuevo registro en la base de datos
    MetodoPago::create([
        'nombreMetPago' => $request->nombreMetPago,
        'imagenMetPago' => $url, // Guardar la URL en el campo correspondiente
        'observacionesMetPago' => $request->nombreMetPago
    ]);

    // Redirigir al índice
    return redirect()->route('metodo.index');
}
}
