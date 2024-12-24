<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePago extends Model
{
    use HasFactory;

    protected $table = 'detalles_pagos';

    protected $fillable = [
        'venta_id',
        'metodo_pago_id',
        'monto',
        'descripcionPago',
        'nombrePago',
    ];
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'venta_id');
    }

    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'metodo_pago_id');
    }
}
