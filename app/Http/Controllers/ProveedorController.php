<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProveedorController extends Controller{
    
    public function index(){
        return view('layouts.proveedor.index');
    }

    public function store(){
        $validatedData = $request->validate([
            'nombreProveedor' => 'required|string|max:70',
            'telefonoProveedor' => 'required|numeric|digits:11',
            'emailProveedor' => 'required|email',
            'rif_cedula' => 'required|numeric|digits:11',
            'direccionProveedor' => 'nullable|string',
        [
                'nombre.required' => 'Este campo es obligatorio.',
          ]
        ]);
    }
}
