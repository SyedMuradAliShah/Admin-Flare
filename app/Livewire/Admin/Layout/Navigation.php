<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Layout;

use Livewire\Component;
use App\Livewire\Admin\Actions\Logout;

class Navigation extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();

        $this->dispatch('swal:alert', [
            'icon' => 'success',
            'title' => 'Logout',
            'text' => 'You have been logged out successfully!',
            'url' => route('admin.login'),
            'timer' => 1000,
        ]);
    }

    public function render()
    {
        return view('livewire.admin.layout.navigation');
    }
}
