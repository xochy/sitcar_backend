<?php

namespace Tests\Feature\Cars;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilterCarsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_filter_cars_by_name()
    {
        Car::factory()->create([
            'name' => 'Benedict Cooper'
        ]);

        Car::factory()->create([
            'name' => 'Terrell Jackson'
        ]);

        $url = route('api.v1.cars.index', ['filter[name]' => 'Benedict']);

        $this->jsonApi()->get($url)
            ->assertJsonCount(1, 'data')
            ->assertSee('Benedict Cooper')
            ->assertDontSee('Terrell Jackson');
    }

    /** @test */
    public function can_filter_cars_by_price()
    {
        Car::factory()->create([
            'name' => 'Benedict Cooper',
            'price' => 350000,
        ]);

        Car::factory()->create([
            'name' => 'Terrell Jackson',
            'price' => 560000
        ]);

        $url = route('api.v1.cars.index', ['filter[price]' => 350000]);

        $this->jsonApi()->get($url)
            ->assertJsonCount(1, 'data')
            ->assertSee('Benedict Cooper')
            ->assertDontSee('Terrell Jackson');
    }


    /** @test */
    public function can_filter_cars_by_trademark()
    {
        Car::factory()->create([
            'name' => 'Benedict Cooper',
            'trademark' => 'Ford',
        ]);

        Car::factory()->create([
            'name' => 'Terrell Jackson',
            'trademark' => 'Nissan'
        ]);

        $url = route('api.v1.cars.index', ['filter[trademark]' => 'Ford']);

        $this->jsonApi()->get($url)
            ->assertJsonCount(1, 'data')
            ->assertSee('Benedict Cooper')
            ->assertDontSee('Terrell Jackson');
    }

    /** @test */
    public function can_filter_cars_by_year()
    {
        Car::factory()->create([
            'name' => 'Benedict Cooper',
            'year' => '2015',
        ]);

        Car::factory()->create([
            'name' => 'Terrell Jackson',
            'year' => '2021'
        ]);

        $url = route('api.v1.cars.index', ['filter[year]' => '2015']);

        $this->jsonApi()->get($url)
            ->assertJsonCount(1, 'data')
            ->assertSee('Benedict Cooper')
            ->assertDontSee('Terrell Jackson');
    }

    /** @test */
    public function can_filter_cars_by_sold()
    {
        Car::factory()->create([
            'name' => 'Benedict Cooper',
            'sold' => true,
        ]);

        Car::factory()->create([
            'name' => 'Terrell Jackson',
            'sold' => false
        ]);

        $url = route('api.v1.cars.index', ['filter[sold]' => true]);

        $this->jsonApi()->get($url)
            ->assertJsonCount(1, 'data')
            ->assertSee('Benedict Cooper')
            ->assertDontSee('Terrell Jackson');
    }

    /** @test */
    public function cannot_filter_cars_by_unknown_filters()
    {
        Car::factory()->create();

        $url = route('api.v1.cars.index', ['filter[unknown]' => 2]);

        $this->jsonApi()->get($url)->assertStatus(400); //*Bad request
    }

    /** @test */
    public function can_search_cars_by_name()
    {
        Car::factory()->count(3)
            ->state(new Sequence(
                ['name' => 'CS55 PLUS 1.5L'],
                ['name' => 'SPARK 1.4L CVT'],
                ['name' => 'EXPLORER 2.3L PLUS'],
            ))
            ->create();

        $url = route('api.v1.cars.index', ['filter[search]' => 'PLUS']);

        $this->jsonApi()->get($url)
            ->assertJsonCount(2, 'data')
            ->assertSee('CS55 PLUS 1.5L')
            ->assertSee('EXPLORER 2.3L PLUS')
            ->assertDontSee('SPARK 1.4L CVT');
    }

    /** @test */
    public function can_search_cars_by_name_with_multiple_terms()
    {
        Car::factory()->count(4)
            ->state(new Sequence(
                ['name' => 'CS55 PLUS 1.5L'],
                ['name' => 'SPARK 1.4L CVT'],
                ['name' => 'EXPLORER 2.3L PLUS'],
                ['name' => 'HRV SPORT 2.0L'],
            ))
            ->create();

        $url = route('api.v1.cars.index', ['filter[search]' => 'SPORT PLUS']);

        $this->jsonApi()->get($url)
            ->assertJsonCount(3, 'data')
            ->assertSee('CS55 PLUS 1.5L')
            ->assertSee('EXPLORER 2.3L PLUS')
            ->assertSee('HRV SPORT 2.0L')
            ->assertDontSee('SPARK 1.4L CVT');
    }
}
