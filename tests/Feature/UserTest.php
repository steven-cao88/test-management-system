<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_admin_can_view_all_users()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $users = User::factory()->count(10)->create();

        $response = $this->getJson('/users');

        $response->assertStatus(200);

        $response->assertJson(
            fn (AssertableJson $json) => $json->has(11)
                ->first(
                    fn ($json) => $json->where('id', $admin->id)
                     ->where('username', $admin->username)
                     ->where('is_admin', 1)
                     ->missing('password')
                     ->etc()
                )
        );
    }

    public function test_admin_can_create_new_user()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $newUserData = [
            'username' => $this->faker->unique()->userName,
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
            'test_chamber' => strval($this->faker->randomDigit),
            'date_of_birth' => $this->faker->dateTimeBetween()->format('Y-m-d H:i:s'),
            'total_score' => $this->faker->randomNumber(2),
            'is_alive' => random_int(0, 1)
        ];

        $response = $this->postJson('/users', $newUserData);

        $response->assertStatus(201);

        unset($newUserData['password']);

        $this->assertDatabaseHas('users', $newUserData);
    }
}
