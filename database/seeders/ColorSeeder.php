<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorSeeder extends Seeder
{
    public function run()
    {
        $colors = [
            ['nombreColor' => 'Rojo', 'codigoHexa' => '#FF0000'],
            ['nombreColor' => 'Verde', 'codigoHexa' => '#008000'],
            ['nombreColor' => 'Azul', 'codigoHexa' => '#0000FF'],
            ['nombreColor' => 'Amarillo', 'codigoHexa' => '#FFFF00'],
            ['nombreColor' => 'Negro', 'codigoHexa' => '#000000'],
            ['nombreColor' => 'Blanco', 'codigoHexa' => '#FFFFFF'],
            ['nombreColor' => 'Naranja', 'codigoHexa' => '#FFA500'],
            ['nombreColor' => 'Morado', 'codigoHexa' => '#800080'],
            ['nombreColor' => 'Gris', 'codigoHexa' => '#808080'],
            ['nombreColor' => 'Marrón', 'codigoHexa' => '#8B4513'],
            ['nombreColor' => 'Rosa', 'codigoHexa' => '#FFC0CB'],
            ['nombreColor' => 'Celeste', 'codigoHexa' => '#87CEEB'],
            ['nombreColor' => 'Turquesa', 'codigoHexa' => '#40E0D0'],
            ['nombreColor' => 'Lila', 'codigoHexa' => '#C8A2C8'],
            ['nombreColor' => 'Fucsia', 'codigoHexa' => '#FF00FF'],
            ['nombreColor' => 'Dorado', 'codigoHexa' => '#FFD700'],
            ['nombreColor' => 'Plateado', 'codigoHexa' => '#C0C0C0'],
            ['nombreColor' => 'Beige', 'codigoHexa' => '#F5F5DC'],
            ['nombreColor' => 'Marrón Claro', 'codigoHexa' => '#D2B48C'],
            ['nombreColor' => 'Verde Oscuro', 'codigoHexa' => '#006400'],
            ['nombreColor' => 'Cian', 'codigoHexa' => '#00FFFF'],
            ['nombreColor' => 'Violeta', 'codigoHexa' => '#EE82EE'],
            ['nombreColor' => 'Magenta', 'codigoHexa' => '#FF00FF'],
            ['nombreColor' => 'Azul Marino', 'codigoHexa' => '#000080'],
            ['nombreColor' => 'Verde Lima', 'codigoHexa' => '#00FF00'],
            ['nombreColor' => 'Ocre', 'codigoHexa' => '#CC7722'],
            ['nombreColor' => 'Salmón', 'codigoHexa' => '#FA8072'],
            ['nombreColor' => 'Coral', 'codigoHexa' => '#FF7F50'],
            ['nombreColor' => 'Lavanda', 'codigoHexa' => '#E6E6FA'],
            ['nombreColor' => 'Azul Acero', 'codigoHexa' => '#4682B4']
        ];

        foreach ($colors as $color) {
            Color::create([
                'nombreColor' => $color['nombreColor'],
                'codigoHexa' => $color['codigoHexa']
            ]);
        }
    }
}