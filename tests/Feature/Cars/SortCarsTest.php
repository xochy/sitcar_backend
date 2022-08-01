<?php

namespace Tests\Feature\Cars;

use App\Models\Car;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SortCarsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_sort_cars_by_name_asc()
    {
        Car::factory()->create(['name' => 'C Name']);
        Car::factory()->create(['name' => 'A Name']);
        Car::factory()->create(['name' => 'B Name']);

        $url = route('api.v1.cars.index', ['sort' => 'name']);

        $this->jsonApi()->get($url)->assertSeeInOrder([
            'A Name',
            'B Name',
            'C Name',
        ]);
    }

    /** @test */
    public function it_can_sort_cars_by_name_desc()
    {
        Car::factory()->create(['name' => 'C Name']);
        Car::factory()->create(['name' => 'A Name']);
        Car::factory()->create(['name' => 'B Name']);

        $url = route('api.v1.cars.index', ['sort' => '-name']);

        $this->jsonApi()->get($url)->assertSeeInOrder([
            'C Name',
            'B Name',
            'A Name',
        ]);
    }

    /** @test */
    public function it_cannot_sort_cars_by_unknown_fields()
    {
        Car::factory()->times(3)->create();

        $url = route('api.v1.cars.index') . '?sort=unknown';

        $this->jsonApi()->get($url)->assertStatus(400);
    }
}
