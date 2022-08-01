<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::query()->delete();
        Permission::query()->delete();

        /* --- Permissions that can be asigned to users for cars management --- */

        //? SuperAdmin role
        $superAdminRole = Role::create(['name' => 'superadmin', 'display_name' => 'Super-Administrador']);

        $createSuperAdmin = Permission::create(['name' => 'create superAdmin', 'display_name' => 'Crear Super-Administrador']);
        $createAdmin = Permission::create(['name' => 'create admin', 'display_name' => 'Crear administrador']);

        $viewInfo   = Permission::create(['name' => 'view info', 'display_name' => 'Ver información']);
        $createInfo = Permission::create(['name' => 'create info', 'display_name' => 'Crear información']);
        $updateInfo = Permission::create(['name' => 'update info', 'display_name' => 'Actualizar información']);
        $deleteInfo = Permission::create(['name' => 'delete info', 'display_name' => 'Eliminar información']);

        // -------------------- Setting permissions to SuperAdmin role ------------------- */

        //? SuperAdmin role
        $superAdminRole->givePermissionTo($createSuperAdmin);
        $superAdminRole->givePermissionTo($createAdmin);
        $superAdminRole->givePermissionTo($viewInfo);
        $superAdminRole->givePermissionTo($createInfo);
        $superAdminRole->givePermissionTo($updateInfo);
        $superAdminRole->givePermissionTo($deleteInfo);

        // -------------------- Setting permissions to Admin role ------------------- */

        $adminRole = Role::create(['name' => 'admin', 'display_name' => 'Administrador']);

        //? Admin role
        $adminRole->givePermissionTo($viewInfo);
        $adminRole->givePermissionTo($createInfo);
        $adminRole->givePermissionTo($updateInfo);
        $adminRole->givePermissionTo($deleteInfo);

        // ------------------- Settings permissions to Costumer role ------------------ */

        //? Costumer role
        $costumerRole = Role::create(['name' => 'costumer', 'display_name' => 'Cliente']);

        $buyCar   = Permission::create(['name' => 'buy car', 'display_name' => 'Comprar Vehículo']);

        $costumerRole->givePermissionTo($viewInfo);
        $costumerRole->givePermissionTo($buyCar);
    }
}
