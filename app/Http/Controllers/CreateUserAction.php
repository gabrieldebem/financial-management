<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Repositories\DTOs\CreateUserDTO;
use App\Repositories\UserRepository;

class CreateUserAction extends Controller
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function __invoke(CreateUserRequest $request)
    {
        $data = new CreateUserDTO(
            $request->name,
            $request->email,
            $request->password
        );

        $user = $this->userRepository->create($data);

        return response()->json($user, 201);
    }
}
