<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TasasCambios;

class TasasCambiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TasasCambios::create([
            'nombreMoneda' => 'USD',
            'valorMoneda'=> '1',
            'baseMoneda'=> '1',
        ]);

        TasasCambios::create([
            'nombreMoneda' => 'VES',
            'valorMoneda'=> '1',
            'baseMoneda'=> '0',
        ]);
    }
}
