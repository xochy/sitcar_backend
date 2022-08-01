<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\PersonalAccessToken;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_login_with_valid_credentials()
    {
        $user = User::factory()->create();

        $response = $this->postJson(route('api.v1.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $token = $response->json('plain_text_token');

        $this->assertNotNull(
            PersonalAccessToken::findToken($token),
            'The plain text token is invalid'
        );
    }

    /** @test */
    public function user_permissions_are_assigned_as_abilities_to_the_token_response()
    {
        $user = User::factory()->create();

        $createCar = Permission::create(['name' => $createCarPermission = 'create car', 'display_name' => 'Crear auto']);
        $updateCar = Permission::create(['name' => $updateCarPermission = 'update car', 'display_name' => 'Actualizar auto']);

        //? Admin role
        $adminRole = Role::create(['name' => 'admin', 'display_name' => 'Administrador']);

        $adminRole->givePermissionTo($createCar);
        $adminRole->givePermissionTo($updateCar);

        $user->assignRole('admin');

        $response = $this->postJson(route('api.v1.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $dbToken = PersonalAccessToken::findToken(
            $response->json('plain_text_token')
        );

        $this->assertTrue($dbToken->can($createCarPermission));
        $this->assertTrue($dbToken->can($updateCarPermission));
        $this->assertFalse($dbToken->can('delete car'));
    }
}
