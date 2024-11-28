<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorSeeder extends Seeder
{
    public function run()
    {
        $colors = [
            'Rojo', 'Verde', 'Azul', 'Amarillo', 'Negro', 'Blanco',
            'Naranja', 'Morado', 'Gris', 'Marrón', 'Rosa', 'Celeste',
            'Turquesa', 'Lila', 'Fucsia', 'Dorado', 'Plateado', 'Beige',
            'Marrón Claro', 'Verde Oscuro'
        ];
        foreach ($colors as $color) {
            Color::create([
                'color' => $color
            ]);
        }
    }
}
