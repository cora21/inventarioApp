<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;

class AlmacenController extends Controller{

    public function index() {
        $almacen = Almacen::all();
        return view('layouts.almacen.index', compact('almacen'));
    }
    public function create(){
        $almacen = Almacen::all();
        return view('layouts.almacen.index', compact('almacen'));
    }
    public function store(Request $request){
        $almacen = new Almacen();

        $almacen->nombre = $request->nombre;
        $almacen->direccion = $request->direccion;
        $almacen->observaciones = $request->observaciones;

        $almacen->save();
        return redirect()->route('almacen.index');
    }
}
