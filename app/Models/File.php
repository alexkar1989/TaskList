<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class File extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'file', 'name', 'type', 'size'];

    protected $hidden = ['file', 'task_id'];

}
