<?php

namespace App\Traits;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasRolesAndPermissions
{
    /**
     * User relationship to roles
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    /**
     * User relationship to permissions
     *
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }

    /**
     * Checking for user membership in groups
     *
     * @param mixed ...$roles
     * @return bool
     */
    public function hasRole(...$roles): bool
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('slug', $role))
                return true;
        }
        return false;
    }

    /**
     * Does the user have permission
     *
     * @param $permission
     * @return bool
     */
    public function hasPermission($permission): bool
    {
        return (bool)$this->permissions->where('slug', $permission)->count();
    }

    /**
     * Does the user have the right
     *
     * @param $permission
     * @return bool
     */
    public function hasPermissionTo($permission): bool
    {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission->slug);
    }

    /**
     * Does the user have permission through the role
     *
     * @param $permission
     * @return bool
     */
    public function hasPermissionThroughRole($permission): bool
    {
        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role))
                return true;

        }
        return false;
    }

    /**
     * Get a list of permission models
     *
     * @param array $permissions
     * @return Collection|Permission[]
     */
    public function getAllPermissions(array $permissions): array|Collection
    {
        return Permission::whereIn('slug', $permissions)->get();
    }


    /**
     * Issuing permissions to a user
     *
     * @param mixed ...$permissions
     * @return $this
     */
    public function givePermissionsTo(... $permissions): static
    {
        $permissions = $this->getAllPermissions($permissions);
        if ($permissions === null)
            return $this;

        $this->permissions()->saveMany($permissions);
        return $this;
    }

    /**
     * Removing permissions from a user
     *
     * @param mixed ...$permissions
     * @return $this
     */
    public function deletePermissions(... $permissions): static
    {
        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;
    }


    /**
     * Update user permissions
     *
     * @param mixed ...$permissions
     * @return HasRolesAndPermissions
     */
    public function refreshPermissions(... $permissions): HasRolesAndPermissions
    {
        $this->permissions()->detach();
        return $this->givePermissionsTo($permissions);
    }

    public function isPersonal(): bool
    {
        return $this->hasRole('admin') || !$this->roles->where('is_personal', 1)->isEmpty();
    }
}
