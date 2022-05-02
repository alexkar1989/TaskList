<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @mixin Builder
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pivot',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return hasMany
     */
    public function tasks(): hasMany
    {
        return $this->hasMany(Task::class, 'user_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    /**
     * @param string|array $roles
     * @return bool
     */
    public function hasRole(string|array $roles): bool
    {
        if (!is_array($roles)) $roles = explode(",", $roles);
        foreach ($roles as $role) {
            if ($this->where('id', $this->id)->whereHas('roles', fn($query) => $query->where('role', $role))->exists()) return true;
        }
        return false;
    }

    /**
     * @param string|array $permissions
     * @return bool
     */
    public function hasPermission(string|array $permissions): bool
    {
        if (!is_array($permissions)) $permissions = explode(",", $permissions);
        foreach ($permissions as $permission) {
            if ($this->where('id', $this->id)->whereHas('roles.permissions', fn($query) => $query->where('permission', $permission))->exists()) return true;
        }
        return false;
    }

}
