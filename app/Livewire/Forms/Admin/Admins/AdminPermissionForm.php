<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Admin\Admins;

use Livewire\Form;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * AdminPermissionForm handles roles and permissions for admins.
 */
class AdminPermissionForm extends Form
{
    public string $guard_name = '';

    public ?int $role_id = 0;

    public array $permissions = [];

    public int $admin_id;

    public array $swal = [];

    public function rules(): array
    {
        return [
            'role_id' => 'required|integer',
            'permissions' => 'array',
        ];
    }

    /**
     * Load admin roles and permissions.
     */
    public function loadAdminPermissions(Admin $admin): void
    {
        $admin->load(['roles', 'permissions']);

        $this->admin_id = $admin->getKey();

        $role = $admin->roles->first();

        $this->role_id = $role ? $role->getKey() : 0;

        $role ??= Role::query()->where('guard_name', $this->guard_name)->first();

        $adminPermissions = $admin->permissions->pluck('name')->toArray();

        if (empty($adminPermissions) && $role) {
            $this->permissions = $role->permissions->pluck('name')->toArray();
        } else {
            $this->permissions = $adminPermissions;
        }
    }

    /**
     * Save the admin role and permissions.
     */
    public function save(): void
    {
        $admin = Admin::query()->find($this->admin_id);

        $role = Role::query()->where('guard_name', $this->guard_name)
            ->where('id', $this->role_id)
            ->first();

        $admin_role = $admin->roles->first();

        // Check if the admin role is protected and try to change it
        if ($admin_role && $admin_role->getKey() !== $role->getKey() && $this->isRoleProtected($admin_role)) {
            $other_admins = Admin::query()->whereHas('roles', function ($query) use ($admin_role): void {
                $query->where('id', $admin_role->getKey());
            })->count();

            if ($other_admins === 1) {
                $this->swal = [
                    'icon' => 'error',
                    'title' => 'Role Protected',
                    'text' => 'The admin role is protected and cannot be changed!',
                    'timer' => 1000,
                ];

                return;
            }
        }

        $admin->syncRoles([$role->name]);

        // If its the only user on the protected role, and try to chnage the prrotected permissions, protected will remain protected.
        if ($this->isRoleProtected($role)) {
            $existingProtectedPermissions = $admin->permissions
                ->filter(fn ($permission): bool => $this->isPermissionProtected($permission))
                ->pluck('name')
                ->toArray();

            $this->permissions = array_merge($existingProtectedPermissions, $this->permissions);
        }

        // Sync permissions
        $admin->syncPermissions($this->permissions);

        $this->swal = [
            'icon' => 'success',
            'title' => 'Role & Permissions Updated',
            'text' => 'The admin role and permissions have been updated successfully!',
            'url' => route('admin.admins.index'),
            'timer' => 1000,
        ];
    }

    /**
     * Check if a role is protected.
     */
    protected function isRoleProtected($role): bool
    {
        return (bool) ($role->protected ?? false);
    }

    /**
     * Check if a permission is protected.
     */
    protected function isPermissionProtected($permission): bool
    {
        return (bool) ($permission->protected ?? false);
    }
}
