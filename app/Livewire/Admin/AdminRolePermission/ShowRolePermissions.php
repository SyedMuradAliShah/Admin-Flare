<?php

declare(strict_types=1);

namespace App\Livewire\Admin\AdminRolePermission;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

#[Title('Admin Roles & Permissions')]
#[Layout('layouts.admin.app')]
class ShowRolePermissions extends Component
{
    use WithPagination;

    public $search = '';

    private string $guardName = 'admin'; // Guard name

    public function mount()
    {
        $this->authorize('view:admin-role-permission', Auth::guard($this->guardName)->user());
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function permissions()
    {
        return Permission::query()->where('guard_name', $this->guardName)
            ->orderByRaw("SUBSTRING_INDEX(name, ':', -1) ASC")
            ->get()
            ->groupBy(function ($permission): string {
                $parts = explode(':', $permission->name);

                return $parts[1];
            });
    }

    #[On('delete')]
    public function deleteRole($id): void
    {
        $this->authorize('delete:admin-role-permission', Auth::guard($this->guardName)->user());

        $role = Role::query()->findOrFail($id);
        $role->delete();

        $this->dispatch('swal:alert', [
            'icon' => 'success',
            'title' => 'Role Deleted',
            'text' => 'Role has been deleted successfully',
        ]);
    }

    #[Computed]
    public function roles()
    {
        return Role::query()->where('guard_name', $this->guardName)
            ->where('name', 'like', '%'.$this->search.'%')
            ->paginate(5);
    }

    #[Computed]
    public function breadcrumb(): array
    {
        return [
            'Dashboard' => route('admin.dashboard'),
            'Admins' => route('admin.admins.index'),
            'Roles & Permissions' => route('admin.admins.roles.index'),
        ];
    }

    public function render()
    {
        return view('livewire.admin.admin-role-permission.show-role-permissions');
    }
}
