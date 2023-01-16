<?php

namespace App\Repositories\DTOs;

use App\Traits\ConvertToArray;
use Illuminate\Support\Facades\Hash;

class CreateUserDTO implements DtoInterface
{
    use ConvertToArray;

    public string $name;
    public string $email;
    public string $password;

    public function __construct(string $name, string $email, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = Hash::make($password);
    }
}
