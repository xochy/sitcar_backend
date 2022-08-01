<?php

namespace Tests\Feature\Cars;

use App\Models\Car;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListCarsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_single_car()
    {
        $car = Car::factory()->create();

        $response = $this->jsonApi()->get(route('api.v1.cars.read', $car));

        $response->assertJson([
            'data' => [
                'type' => 'cars',
                'id' => $car->getRouteKey(),
                'attributes' => [
                    'name'      => $car->name,
                    'price'     => $car->price,
                    'trademark' => $car->trademark,
                    'year'      => $car->year,
                    'sold'      => $car->sold,
                    'slug'      => $car->slug,
                ],
                'links' => [
                    'self' => route('api.v1.cars.read', $car)
                ]
            ]
        ]);
    }

    /** @test */
    public function can_fetch_all_cars()
    {
        $cars = Car::factory()->count(3)->create();

        $response = $this->jsonApi()->get(route('api.v1.cars.index'));

        $response->assertJson([
            'data' => [
                [
                    'type' => 'cars',
                    'id' => $cars[0]->getRouteKey(),
                    'attributes' => [
                        'name'      => $cars[0]->name,
                        'price'     => $cars[0]->price,
                        'trademark' => $cars[0]->trademark,
                        'year'      => $cars[0]->year,
                        'sold'      => $cars[0]->sold,
                        'slug'      => $cars[0]->slug,
                    ],
                    'links' => [
                        'self' => route('api.v1.cars.read', $cars[0])
                    ]
                ],
                [
                    'type' => 'cars',
                    'id' => $cars[1]->getRouteKey(),
                    'attributes' => [
                        'name'      => $cars[1]->name,
                        'price'     => $cars[1]->price,
                        'trademark' => $cars[1]->trademark,
                        'year'      => $cars[1]->year,
                        'sold'      => $cars[1]->sold,
                        'slug'      => $cars[1]->slug,
                    ],
                    'links' => [
                        'self' => route('api.v1.cars.read', $cars[1])
                    ]
                ],
                [
                    'type' => 'cars',
                    'id' => $cars[2]->getRouteKey(),
                    'attributes' => [
                        'name'      => $cars[2]->name,
                        'price'     => $cars[2]->price,
                        'trademark' => $cars[2]->trademark,
                        'year'      => $cars[2]->year,
                        'sold'      => $cars[2]->sold,
                        'slug'      => $cars[2]->slug,
                    ],
                    'links' => [
                        'self' => route('api.v1.cars.read', $cars[2])
                    ]
                ],
            ],
        ]);
    }
}
