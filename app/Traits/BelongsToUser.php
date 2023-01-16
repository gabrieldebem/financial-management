<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToUser
{
    public static function booted()
    {
        static::addGlobalScope('belongsToUser', function(Builder $query) {
            if (auth()->check()) {
                $query->where('user_id', auth()->id());
            }
        });
    }
}
