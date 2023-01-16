<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateUserActionTest extends TestCase
{
    use WithFaker;

    public function testCreateUser()
    {
        $name = $this->faker->name();
        $email = $this->faker->email();
        $password = $this->faker->password(8);

        $this->post('/api/users', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ])->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email,
        ]);

        $user = User::where('email', $email)->first();

        $this->assertTrue(Hash::check($password, $user->password));
    }

    public function testCantCreateUserWithInvalidEmail()
    {
        $name = $this->faker->name;
        $email = $this->faker->name;
        $password = $this->faker->password(8);

        $this->post('/api/users', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ])->assertStatus(422);

        $this->assertDatabaseMissing('users', [
            'name' => $name,
            'email' => $email,
        ]);
    }

    public function testCantCreateUserWithInvalidPassword()
    {
        $name = $this->faker->name;
        $email = $this->faker->email;
        $password = '123';

        $this->post('/api/users', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ])->assertStatus(422);

        $this->assertDatabaseMissing('users', [
            'name' => $name,
            'email' => $email,
        ]);
    }
}
