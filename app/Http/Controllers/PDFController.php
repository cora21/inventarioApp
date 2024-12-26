<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller{


    public function generarPDF() {
        // Cargar la vista
        $pdf = PDF::loadView('layouts.pdf.pdfProducto');

        // Mostrar el PDF en el navegador
        return $pdf->stream('pdfProducto.pdf');
    }

    public function generarFacturaPDF() {
        // Cargar la vista
        $pdf = PDF::loadView('layouts.pdf.pdfFactura');

        // Mostrar el PDF en el navegador
        return $pdf->stream('pdfFactura.pdf');
    }
}
