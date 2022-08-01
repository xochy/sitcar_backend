<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Str;

class ListUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_single_user()
    {
        $user = User::factory()->create();

        $response = $this->jsonApi()->get(route('api.v1.users.read', $user))
            ->assertSee($user->slug);

        $this->assertTrue(Str::isUuid($response->json('data.id')), "The user 'id' must be Uuid.");
    }

    /** @test */
    public function can_fetch_all_users()
    {
        $users = User::factory()->count(3)->create();

        $this->jsonApi()->get(route('api.v1.users.index'))
        ->assertSee($users[0]->slug);
    }
}
