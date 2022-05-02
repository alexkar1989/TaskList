<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

/**
 * @mixin Builder
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'text', 'cost', 'status', 'user_id', 'creator_id'];

    protected $casts = [
        'created_at' => "datetime:Y-m-d H:i",
        'updated_at' => "datetime:Y-m-d H:i",
    ];

    /**
     * @return HasMany
     */
    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
