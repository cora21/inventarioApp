<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos';
    protected $fillable = [
        'nombreProducto',
        'marcaProducto',
        'modeloProducto',
        'descripcionProducto',
        'categoria_id',
        'proveedor_id',
        'almacen_id',
        'cantidadDisponibleProducto',
        'precioUnitarioProducto',
        'precioTotal',
    ];

        public function categoria(){
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function proveedor(){
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public function almacenes(){
        return $this->belongsToMany(Almacen::class, 'producto_almacen')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }
}
