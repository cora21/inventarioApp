<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Almacen;
use App\Models\Color;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AlmacenSeeder::class);
        $this->call(MetodoPagoSeeder::class);
        $this->call(ColorSeeder::class);
        User::factory(10)->create()->each(function ($user) {
            $user->assignRole('developer');
        });
    }
}
