<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';

    protected $fillable = [

        'montoTotalVenta',
        'metodo_pago_id',   
        'almacen_id', 
        'tasa_cambio_id', 
    ];

    public function detallesVenta(){
        return $this->hasMany(DetalleVenta::class, 'venta_id');
    }

    public function detallesPago(){
        return $this->hasMany(DetallePago::class, 'venta_id');
    }

    public function metodoPago(){
        return $this->belongsTo(MetodoPago::class, 'metodo_pago_id');
    }

    public function almacen(){
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }

    public function tasaCambio(){
        return $this->belongsTo(TasasCambios::class, 'tasa_cambio_id');
    }

    public function historiaTasaCambio(){
        return $this->hasMany(HistoriaTasasCambios::class, 'venta_id');
    }
}
