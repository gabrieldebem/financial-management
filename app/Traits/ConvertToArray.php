<?php
namespace App\Traits;

trait ConvertToArray
{
    public function toArray(): array
    {
        $arr = get_object_vars($this);

        return $arr;
    }
}
