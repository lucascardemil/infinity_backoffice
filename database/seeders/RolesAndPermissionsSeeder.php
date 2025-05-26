<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::firstOrCreate(['name' => 'propiedad']);
        Permission::firstOrCreate(['name' => 'atributo_adicional']);
        Permission::firstOrCreate(['name' => 'categoria_secundaria']);
        Permission::firstOrCreate(['name' => 'ubicacion']);
        Permission::firstOrCreate(['name' => 'formato_negocio']);
        Permission::firstOrCreate(['name' => 'tipo_propiedad']);
        Permission::firstOrCreate(['name' => 'usuarios']);
        Permission::firstOrCreate(['name' => 'roles']);
        Permission::firstOrCreate(['name' => 'configuraciones']);
        Permission::firstOrCreate(['name' => 'clientes']);
        Permission::firstOrCreate(['name' => 'uf']);
        Permission::firstOrCreate(['name' => 'whatsapp']);

        $adminRole = Role::firstOrCreate(['name' => 'administrador']);

        $adminRole->givePermissionTo('propiedad');
        $adminRole->givePermissionTo('atributo_adicional');
        $adminRole->givePermissionTo('categoria_secundaria');
        $adminRole->givePermissionTo('ubicacion');
        $adminRole->givePermissionTo('formato_negocio');
        $adminRole->givePermissionTo('tipo_propiedad');
        $adminRole->givePermissionTo('usuarios');
        $adminRole->givePermissionTo('roles');
        $adminRole->givePermissionTo('configuraciones');
        $adminRole->givePermissionTo('clientes');
        $adminRole->givePermissionTo('uf');
        $adminRole->givePermissionTo('whatsapp');

        $admin = User::firstOrCreate([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'status' => 1
        ]);
        $admin->assignRole('administrador');
    }
}
