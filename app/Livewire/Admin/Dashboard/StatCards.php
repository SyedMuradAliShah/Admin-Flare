<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Dashboard;

use App\Models\Admin;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class StatCards extends Component
{
    #[Computed]
    public function totalPermissions()
    {
        return Permission::query()->count();
    }

    #[Computed]
    public function totalRoles()
    {
        return Role::query()->count();
    }

    #[Computed]
    public function totalAdmins()
    {
        return Admin::query()->count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard.stat-cards');
    }
}
