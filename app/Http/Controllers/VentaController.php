<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VentaController extends Controller{



    public function index(){
        return view('layouts.venta.index');
    }
}


