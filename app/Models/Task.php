<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

/**
 * @mixin Builder
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'text', 'cost', 'status'];

    /**
     * @return HasMany
     */
    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }

    /**
     * @return HasOneThrough
     */
    public function user()
    {
        return $this->hasOneThrough(User::class, UserTask::class, 'task_id', 'id', 'task_id', 'user_id');
    }
}
