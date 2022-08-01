<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilterUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_filter_users_by_name()
    {
        $users = User::factory()->count(2)
            ->state(new Sequence(
                ['name' => 'Aurelia Sloan'],
                ['name' => 'Kai Frost'],
            ))
            ->create();

        $url = route('api.v1.users.index', ['filter[name]' => 'Aurelia']);

        $this->jsonApi()->get($url)
            ->assertJsonCount(1, 'data')
            ->assertSee('Aurelia Sloan')
            ->assertDontSee('Kai Frost');
    }

    /** @test */
    public function can_filter_users_by_email()
    {
        User::factory()->count(2)
            ->state(new Sequence(
                ['email' => 'aurelia@mail.com'],
                ['email' => 'kai@mail.com'],
            ))
            ->create();

        $url = route('api.v1.users.index', ['filter[email]' => 'aurelia']);

        $this->jsonApi()->get($url)
            ->assertJsonCount(1, 'data')
            ->assertSee('aurelia')
            ->assertDontSee('kai');
    }
}
