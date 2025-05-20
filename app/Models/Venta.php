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

    public function categoria(){
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
    public function producto(){
        return $this->belongsTo(Producto::class, 'producto_id');
    }
    public function historiaTasaCambio(){
        return $this->hasMany(HistoriaTasasCambios::class, 'venta_id');
    }
}
