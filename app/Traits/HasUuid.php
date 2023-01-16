<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
    /**
     * Initialize the trait
     *
     * @return void
     */
    public function initializeHasUuid()
    {
        $this->incrementing = false;
        $this->keyType = 'string';
        $this->casts['id'] = 'string';
        $this->id = Str::uuid()->toString(); // @phpstan-ignore-line
    }
}
