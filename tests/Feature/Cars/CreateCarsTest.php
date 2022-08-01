<?php

namespace Tests\Feature\Cars;

use App\Models\Car;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CreateCarsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        if (!Role::whereName('admin')->exists()) {
            $this->seed(RoleSeeder::class);
        }
    }

    /** @test */
    public function guests_users_cannot_create_cars()
    {
        $car = array_filter(Car::factory()->raw());

        $this->jsonApi()->withData([
            'type' => 'cars',
            'attributes' => $car,
        ])
            ->post(route('api.v1.cars.create'))
            ->assertStatus(401); //*No autorizado

        $this->assertDatabaseMissing('cars', $car);
    }

    /** @test */
    public function authenticated_users_cannot_create_cars_without_permissions()
    {
        $admin = User::factory()->create();

        $car = array_filter(Car::factory()->raw());

        Sanctum::actingAs($admin);

        $this->jsonApi()->withData([
            'type' => 'cars',
            'attributes' => $car,
        ])
            ->post(route('api.v1.cars.create'))
            ->assertStatus(403); //* Prohibido

        $this->assertDatabaseCount('cars', 0);
    }

    /** @test */
    public function authenticated_users_can_create_cars()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $car = array_filter(Car::factory()->raw());

        Sanctum::actingAs($admin);

        $this->jsonApi()->withData([
            'type' => 'cars',
            'attributes' => $car,
        ])
            ->post(route('api.v1.cars.create'))
            ->assertCreated();

        $this->assertDatabaseHas('cars', [
            'name' => $car['name'],
        ]);
    }

    /** @test */
    public function name_is_required()
    {
        $car = Car::factory()->raw(['name' => '']);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        Sanctum::actingAs($admin);

        $this->jsonApi()->withData([
            'type' => 'cars',
            'attributes' => $car,
        ])
            ->post(route('api.v1.cars.create'))
            ->assertStatus(422)
            ->assertSee('\/data\/attributes\/name');

        $this->assertDatabaseMissing('cars', $car);
    }
}
