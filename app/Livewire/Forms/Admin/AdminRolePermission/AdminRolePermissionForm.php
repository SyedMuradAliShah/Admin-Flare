<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Admin\AdminRolePermission;

use Livewire\Form;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class AdminRolePermissionForm extends Form
{
    public string $role_name = ''; // Holds the role name

    public array $permissions = []; // Holds the selected permissions

    public ?int $role_id = null;

    public array $swal = [];

    public Role $role;

    public function rules(): array
    {
        return [
            'role_name' => 'required|string|max:255|unique:roles,name,'.$this->role_id,
            'permissions' => 'array',
        ];
    }

    public function loadRole(Role $role): void
    {
        $this->role_id = $role->id;
        $this->role_name = Str::title(Str::replace('-', ' ', $role->name));
        $this->permissions = $role->permissions->pluck('name')->toArray();
    }

    public function save(): void
    {
        $role = Role::query()->updateOrCreate(['id' => $this->role_id], ['name' => Str::slug($this->role_name), 'guard_name' => 'admin']);

        // Sync permissions to the role
        $role->syncPermissions($this->permissions);

        $this->swal = [
            'icon' => 'success',
            'title' => 'Role Saved',
            'text' => 'The role has been saved successfully!',
            'url' => route('admin.admins.roles.index'),
            'timer' => 1000,
        ];
    }
}
