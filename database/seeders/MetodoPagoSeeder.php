<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MetodoPago;

class MetodoPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        MetodoPago::create([
            'nombreMetPago' => 'Efectivo divisas ó Bolívares',
            'observacionesMetPago' => 'Pago en efectivo.',
            'imagenMetPago' => 'imagenes/efectivo.png',
        ]);

        MetodoPago::create([
            'nombreMetPago' => 'Pago Móvil',
            'observacionesMetPago' => 'Pago por transferencia bancaria.',
            'imagenMetPago' => 'imagenes/pagoMovil.png',
        ]);

        MetodoPago::create([
            'nombreMetPago' => 'Tarjeta de Crédito',
            'observacionesMetPago' => 'Pago con tarjeta de crédito.',
            'imagenMetPago' => 'imagenes/credito.png',
        ]);

        MetodoPago::create([
            'nombreMetPago' => 'Tarjeta de Débito',
            'observacionesMetPago' => 'Pago con tarjeta de débito.',
            'imagenMetPago' => 'imagenes/debito.png',
        ]);

        MetodoPago::create([
            'nombreMetPago' => 'Combinado',
            'observacionesMetPago' => 'Combinado',
            'imagenMetPago' => null,
        ]);

    }
}
