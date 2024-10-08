<?php

declare(strict_types=1);

namespace App\Livewire\Admin\AdminRolePermission;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Livewire\Forms\Admin\AdminRolePermission\AdminRolePermissionForm;

#[Title('Edit Admin Roles')]
#[Layout('layouts.admin.app')]
class EditRolePermisison extends Component
{
    public AdminRolePermissionForm $form;

    public Role $role;

    private string $guardName = 'admin'; // Guard name

    public function mount(Role $role) : void
    {
        $this->authorize('update:admin-role-permission', Auth::guard($this->guardName)->user());

        $this->form->loadRole($role);
    }

    public function save() : void
    {
        $this->authorize('update:admin-role-permission', Auth::guard($this->guardName)->user());

        $this->form->validate();

        $this->form->save();

        if ($this->form->swal !== [])
        {
            $this->dispatch('swal:alert', $this->form->swal);
            $this->form->swal = [];
        }
    }

    #[Computed]
    public function permissions() : Collection
    {
        return Permission::query()->where('guard_name', $this->guardName)
            ->orderByRaw("SUBSTRING_INDEX(name, ':', -1) ASC")
            ->get()
            ->groupBy(function ($permission) : string
            {
                $parts = explode(':', $permission->name);

                return $parts[1];
            });
    }

    #[Computed]
    public function breadcrumb() : array
    {
        return [
            'Dashboard'           => route('admin.dashboard'),
            'Admins'              => route('admin.admins.index'),
            'Roles & Permissions' => route('admin.admins.roles.index'),
            'Edit Role'           => '',
        ];
    }

    public function render()
    {
        return view('livewire.admin.admin-role-permission.edit-role-permisison');
    }
}
