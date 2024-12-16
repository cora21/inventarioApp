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
}
