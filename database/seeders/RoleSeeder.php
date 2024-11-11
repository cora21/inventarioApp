<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin =  Role::create(['name'=> 'admin']);
        $analist =Role::create(['name'=> 'analist']);
        $developer = Role::create(['name'=> 'developer']);

        Permission::create(['name' => 'dashboard'])->syncRoles([$admin, $analist, $developer]);
        Permission::create(['name' => 'users.index'])->syncRoles([$admin, $analist]);
        Permission::create(['name' => 'users.show'])->syncRoles([$admin, $analist]);
        Permission::create(['name' => 'users.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'users.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'users.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'users.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'users.destroy'])->syncRoles([$admin]);
    }
}
