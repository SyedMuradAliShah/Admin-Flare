<?php

declare(strict_types=1);

namespace App\Livewire\Admin\AdminRolePermission;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use App\Livewire\Forms\Admin\AdminRolePermission\AdminRolePermissionForm;

#[Title('Create Admin Roles')]
#[Layout('layouts.admin.app')]
class CreateRolePermisison extends Component
{
    public AdminRolePermissionForm $form;

    private string $guardName = 'admin'; // Guard name

    public function mount(): void
    {
        $this->authorize('create:admin-role-permission', Auth::guard($this->guardName)->user());
    }

    public function save(): void
    {
        $this->authorize('create:admin-role-permission', Auth::guard($this->guardName)->user());

        $this->form->validate();

        $this->form->save();

        if ($this->form->swal !== []) {
            $this->dispatch('swal:alert', $this->form->swal);
            $this->form->swal = [];

            return;
        }
    }

    /**
     * @return Collection<string, Collection<int, Permission>>
     */
    #[Computed]
    public function permissions(): Collection
    {
        return Permission::query()->where('guard_name', $this->guardName)
            ->orderByRaw("SUBSTRING_INDEX(name, ':', -1) ASC")
            ->get()
            ->groupBy(function (Permission $permission): string {
                $parts = explode(':', $permission->name);

                return $parts[1];
            })
            ->map(fn ($group) => collect($group));
    }

    #[Computed]
    public function breadcrumb(): array
    {
        return [
            'Dashboard' => route('admin.dashboard'),
            'Admins' => route('admin.admins.index'),
            'Roles & Permissions' => route('admin.admins.roles.index'),
            'Create' => '',
        ];
    }

    public function render(): View
    {
        return view('livewire.admin.admin-role-permission.create-role-permisison');
    }
}
