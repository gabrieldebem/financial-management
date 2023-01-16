<?php

namespace App\Services;

use App\Exceptions\InvalidCredentialsException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected User $user;

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function checkPassword(string $password): self
    {
        if (! Hash::check($password, $this->user->password)) {
            throw new InvalidCredentialsException();
        }

        return $this;
    }

    public function generateToken(): string
    {
        return $this->user->createToken('authToken')->plainTextToken;
    }
}
