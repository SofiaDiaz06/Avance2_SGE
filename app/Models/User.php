<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'active',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $attributes = [
        'active' => true,
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'active' => 'boolean',
        ];
    }

    public function activeRole(): ?Role
    {
        $roles = $this->roles;
        if ($roles->count() === 1) {
            return $roles->first();
        }
        return $roles->firstWhere('name', session('active_role'));
    }

    public function hasMultipleRoles(): bool
    {
        return $this->roles->count() > 1;
    }

    public function hasPermissionInActiveRole(string $permission): bool
    {
        try {
            if ($this->hasDirectPermission($permission)) {
                return true;
            }
            $role = $this->activeRole();
            return $role
                ? $role->hasPermissionTo($permission)
                : $this->hasPermissionTo($permission);
        } catch (PermissionDoesNotExist) {
            return false;
        }
    }
}