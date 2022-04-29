<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class Permission extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['permission', 'name'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, RolePermission::class);
    }
}
