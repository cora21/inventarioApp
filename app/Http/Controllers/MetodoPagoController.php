<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MetodoPagoController extends Controller{
    public function index(){
        return view('layouts.metodoPago.index');
    }
}
