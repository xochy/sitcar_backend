<?php

namespace Tests\Feature\Roles;

use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ListRolesTest extends TestCase
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
    public function can_fetch_single_role()
    {
        $role = Role::whereName('costumer')->first();

        $response = $this->jsonApi()->get(route('api.v1.roles.read', $role));

        $response->assertJson([
            'data' => [
                'type' => 'roles',
                'id' => $role->id,
                'attributes' => [
                    'name' => $role->name,
                ],
                'links' => [
                    'self' => route('api.v1.roles.read', $role)
                ]
            ]
        ]);
    }

    /** @test */
    public function can_fetch_all_roles()
    {
        $roles = Role::all();

        $response = $this->jsonApi()->get(route('api.v1.roles.index'));

        $response->assertJson([
            'data' => [
                [
                    'type' => 'roles',
                    'id' => $roles[0]->id,
                    'attributes' => [
                        'name' => $roles[0]->name,
                    ],
                    'links' => [
                        'self' => route('api.v1.roles.read', $roles[0])
                    ]
                ],
                [
                    'type' => 'roles',
                    'id' => $roles[1]->id,
                    'attributes' => [
                        'name' => $roles[1]->name,
                    ],
                    'links' => [
                        'self' => route('api.v1.roles.read', $roles[1])
                    ]
                ],
                [
                    'type' => 'roles',
                    'id' => $roles[2]->id,
                    'attributes' => [
                        'name' => $roles[2]->name,
                    ],
                    'links' => [
                        'self' => route('api.v1.roles.read', $roles[2])
                    ]
                ],
            ],
        ]);
    }
}
