<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;


class ProveedorController extends Controller{

    public function index(){
        return view('layouts.proveedor.index');
    }
    public function create(){
        $proveedor = Proveedor::all();
        return view('layouts.proveedor.index', compact('proveedor'));
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'nombreProveedor' => 'required',
            'telefonoProveedor' => 'required|numeric|digits:11',
            'emailProveedor' => 'required|email',
            'rif_cedula' => 'required|numeric',
            'direccionProveedor' => 'nullable|string',
            'nacionalidad' => 'nullable|string',
        ],[
                'nombreProveedor.required' => 'Este campo es obligatorio.',
                'telefonoProveedor.required' => 'Este campo es obligatorio.',
                'telefonoProveedor.numeric' => 'Este campo solo acepta números.',
                'telefonoProveedor.digits' => 'Debe ingresar un número valido.',
                'emailProveedor.required' => 'Este campo es obligatorio.',
                'rif_cedula.required' => 'Este campo es obligatorio.',
                'rif_cedula.numeric' => 'Este campo solo acepta números.',
        ]);

        $proveedor = new Proveedor();
        $proveedor->nombreProveedor = $request->nombreProveedor;
        $proveedor->telefonoProveedor = $request->telefonoProveedor;
        $proveedor->emailProveedor = $request->emailProveedor;
        $proveedor->rif_cedula = $request->rif_cedula;
        $proveedor->direccionProveedor = $request->direccionProveedor;
        $proveedor->nacionalidad = $request->nacionalidad;
        Proveedor::create($request->only(['nombreProveedor', 'telefonoProveedor', 'emailProveedor', 'rif_cedula', 'direccionProveedor','nacionalidad']));
        return redirect()->route('proveedor.index')->with('success', 'Proveedor registrado exitosamente.');
    }
}
