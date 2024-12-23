<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TasasCambios extends Model{
    
    protected $table = 'tasas_cambios';

    protected $fillable = [
        'nombreMoneda',
        'valorMoneda',
        'baseMoneda',
    ];
}
