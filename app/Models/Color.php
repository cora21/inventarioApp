<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    protected $table = 'colores';
    protected $fillable = [
        'nombreColor',
        'codigoHexa',
    ];

    public function productos(){
        return $this->belongsToMany(Producto::class, 'productos_colores')
                    ->withPivot('unidadesDisponibleProducto') // Agregamos el campo extra de la tabla intermedia
                    ->withTimestamps();
    }
    // Relación con colores
    public function colores(){
        return $this->belongsToMany(Color::class, 'productos_colores')
                    ->withPivot('unidadesDisponibleProducto') // Campo adicional de la tabla intermedia
                    ->withTimestamps();
    }
}
