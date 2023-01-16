<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidCredentialsException;
use App\Http\Requests\AuthUserRequest;
use App\Models\User;
use App\Services\AuthService;

class AuthUserAction extends Controller
{
    public function __construct(private readonly AuthService $authService)
    {
    }

    public function __invoke(AuthUserRequest $request)
    {
        $user = User::where('email', $request->username)->first();

        if (! $user) {
            throw new InvalidCredentialsException();
        }

        $token = $this->authService
            ->setUser($user)
            ->checkPassword($request->password)
            ->generateToken();

        return response()->json([
            'token' => $token,
            'user' => $user,
        ], 200);
    }
}
