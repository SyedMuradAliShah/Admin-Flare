<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Auth;

use Livewire\Component;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Forms\Admin\Auth\ForgotPasswordForm;

#[Title('Admin Forgot Password')]
#[Layout('layouts.admin.guest')]
class ForgotPassword extends Component
{
    public ForgotPasswordForm $form;

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate();

        $this->form->restPassword();

        if ($this->form->swal !== []) {
            $this->dispatch('swal:alert', $this->form->swal);
            $this->form->swal = [];
        }
    }

    public function render(): View
    {
        return view('livewire.admin.auth.forgot-password');
    }
}
