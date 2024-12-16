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

    // se debe borrar siempre y generar con php artisan storage:link
    public function store(Request $request){
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
    return redirect()->route('metodo.index')->with('success', 'Metdo de Pago registrado exitosamente.');
}

public function show($id){
    $metPago = MetodoPago::find($id);
    return view('layouts.metodoPago.show', compact('metPago'));
}

public function edit($id){
    $metPago = MetodoPago::find($id);
    return view('layouts.metodoPago.edit', compact('metPago'));
}
public function update(Request $request, $id)
{
    // Validar los campos
    $request->validate([
        'nombreMetPago' => 'required|max:255',
        'imageMetodo' => 'image', // Verifica que el archivo sea una imagen
    ], [
        'nombreMetPago.required' => 'Este campo es obligatorio.',
        'imageMetodo.image' => 'Debe subir una imagen válida.',
    ]);

    // Buscar el registro existente
    $metPago = MetodoPago::findOrFail($id);

    // Procesar la imagen, si se ha subido una nueva
    if ($request->hasFile('imageMetodo')) {
        // Eliminar la imagen anterior si existe
        if ($metPago->imagenMetPago && Storage::exists(str_replace('/storage/', 'public/', $metPago->imagenMetPago))) {
            Storage::delete(str_replace('/storage/', 'public/', $metPago->imagenMetPago));
        }

        // Subir la nueva imagen
        $imagen = $request->file('imageMetodo')->store('public/imagenes');
        $url = Storage::url($imagen); // Genera la URL accesible públicamente
    } else {
        // Mantener la URL de la imagen existente
        $url = $metPago->imagenMetPago;
    }

    // Actualizar el registro en la base de datos
    $metPago->update([
        'nombreMetPago' => $request->nombreMetPago,
        'imagenMetPago' => $url, // Guardar la nueva URL o la existente
        'observacionesMetPago' => $request->observacionesMetPago,
    ]);

    // Redirigir al índice con un mensaje de éxito
    return redirect()->route('metodo.index')->with('success', 'Método de pago actualizado con éxito.');
}

}
