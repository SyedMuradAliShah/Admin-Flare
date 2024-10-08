<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

#[Title('Dashboard')]
#[Layout('layouts.admin.app')]
class Dashboard extends Component
{
    #[Computed]
    public function breadcrumb(): array
    {
        return [];
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
