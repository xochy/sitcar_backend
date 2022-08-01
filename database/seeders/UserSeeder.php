<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->delete();

        //? Create a SuperAdmin user
        $superAdmin = User::factory()->create([
            'email' => 'superadmin@superadmin.com',
        ]);

        $superAdmin->assignRole('superadmin');

        //? Create an Admin user
        $admin = User::factory()->create([
            'email' => 'admin@admin.com',
        ]);

        $admin->assignRole('admin');

        //? Create a Costumer user
        $costumer = User::factory()->create([
            'email' => 'costumer@costumer.com',
        ]);

        $costumer->assignRole('costumer');
    }
}
