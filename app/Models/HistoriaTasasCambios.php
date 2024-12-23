<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriaTasasCambios extends Model{
    protected $table = 'historial_tasas_cambios';

    protected $fillable = [
        'nombreMonedaH',
        'valorMonedaH',
    ];
}
