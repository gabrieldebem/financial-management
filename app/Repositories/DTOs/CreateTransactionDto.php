<?php
namespace App\Repositories\DTOs;

use App\Enums\Direction;
use App\Traits\ConvertToArray;

class CreateTransactionDto implements DtoInterface
{
    use ConvertToArray;

    public string $user_id;
    public int $amount;
    public Direction $direction;
    public string $description;

    public function __construct(string $user_id, int $amount, Direction $direction, string $description)
    {
        $this->user_id = $user_id;
        $this->amount = $amount;
        $this->direction = $direction;
        $this->description = $description;
    }
}
