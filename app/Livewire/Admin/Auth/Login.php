<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Auth;

use Livewire\Component;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Session;
use App\Livewire\Forms\Admin\Auth\LoginForm;

#[Title('Admin Login')]
#[Layout('layouts.admin.guest')]
class Login extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        if ($this->form->swal !== []) {
            $this->dispatch('swal:alert', $this->form->swal);

            $this->form->swal = [];

            return;
        }

        Session::regenerate();
    }

    public function render(): View
    {
        return view('livewire.admin.auth.login');
    }
}
