<?php

namespace App\Models;

use App\Enums\Direction;
use App\Traits\BelongsToUser;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;
    use HasUuid;
    use BelongsToUser;

    protected $fillable = [
        'user_id',
        'amount',
        'direction',
        'description',
    ];

    protected $casts = [
        'user_id' => 'string',
        'amount' => 'integer',
        'description' => 'string',
        'direction' => Direction::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
