<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Almacen;

class AlmacenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Almacen::create([
            'nombre' => 'Principal',
            'direccion' => 'Sótano B',
            'observaciones' => 'No posee ninguna llave', // Si no tienes observaciones, puedes dejarlo como null
        ]);
    }
}
