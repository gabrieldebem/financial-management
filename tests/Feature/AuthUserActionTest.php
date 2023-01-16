<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthUserActionTest extends TestCase
{
    use WithFaker;

    public function testAuthUser()
    {
        $user = User::factory()
            ->create();

        $this->post('/api/issue-token', [
            'username' => $user->email,
            'password' => 'password',
        ])
            ->assertSuccessful()
            ->assertJson([
                'user' => $user->toArray(),
            ]);
    }

    public function testCantAuthWithInvalidCredentials()
    {
        $this->post('/api/issue-token', [
            'username' => $this->faker->email(),
            'password' => $this->faker->password(8),
        ])
            ->assertUnauthorized()
            ->assertJson([
                'message' => 'Username or password is incorrect',
            ]);
    }
}
