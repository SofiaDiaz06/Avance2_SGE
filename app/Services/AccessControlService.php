<?php

namespace App\Services;

use App\Models\User;
use App\Support\PermissionCatalog;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AccessControlService
{
    public function saveUser(User $user, array $data, User $actor): User
    {
        $roles = $data['roles'] ?? [];
        $active = (bool) ($data['active'] ?? false);

        if ($user->exists && $user->is($actor) && !$active) {
            throw ValidationException::withMessages(['active' => 'No puede desactivar su propio usuario.']);
        }

        $this->ensureAnAdminRemains($user, $roles, $active);

        return DB::transaction(function () use ($user, $data, $roles, $active) {
            $user->fill([
                'name' => $data['name'],
                'email' => $data['email'],
                'active' => $active,
            ]);

            if (!empty($data['password'])) {
                $user->password = $data['password'];
            }

            if (!$user->exists) {
                $user->email_verified_at = now();
            }

            $user->save();
            $user->syncRoles($roles);
            $user->syncPermissions($data['permissions'] ?? []);

            return $user;
        });
    }

    public function toggleActive(User $user, User $actor): User
    {
        if ($user->is($actor)) {
            throw ValidationException::withMessages(['active' => 'No puede desactivar su propio usuario.']);
        }

        if ($user->active) {
            $this->ensureAnAdminRemains($user, $user->getRoleNames()->all(), false);
        }

        $user->update(['active' => !$user->active]);
        return $user;
    }

    public function ensureAnAdminRemains(User $user, array $newRoles, bool $active): void
    {
        $admin = PermissionCatalog::superRole();
        $wasAdmin = $user->exists && $user->hasRole($admin) && $user->active;
        $willBeAdmin = in_array($admin, $newRoles, true) && $active;

        if (!$wasAdmin || $willBeAdmin) {
            return;
        }

        $otherAdmins = User::role($admin)
            ->where('active', true)
            ->whereKeyNot($user->id)
            ->count();

        if ($otherAdmins === 0) {
            throw ValidationException::withMessages([
                'roles' => "Debe existir al menos un usuario activo con el rol «{$admin}».",
            ]);
        }
    }

    public function syncRolePermissions(Role $role, array $permissions): void
    {
        if ($role->name === PermissionCatalog::superRole()) {
            $role->syncPermissions(Permission::all());
            return;
        }
        $role->syncPermissions($permissions);
    }

    public function createPermission(string $action, string $module): Permission
    {
        $permission = Permission::create(['name' => "{$action}-{$module}", 'guard_name' => 'web']);
        Role::findByName(PermissionCatalog::superRole())->givePermissionTo($permission);
        return $permission;
    }

    public function deletePermission(Permission $permission): void
    {
        $rolesUsing = $permission->roles()->where('name', '!=', PermissionCatalog::superRole())->pluck('name');
        $usersUsing = $permission->users()->count();

        if ($rolesUsing->isNotEmpty() || $usersUsing > 0) {
            throw ValidationException::withMessages([
                'permission' => "El permiso «{$permission->name}» está en uso (roles: " . ($rolesUsing->join(', ') ?: 'ninguno') . ", usuarios con permiso directo: {$usersUsing}).",
            ]);
        }

        $permission->delete();
    }
}