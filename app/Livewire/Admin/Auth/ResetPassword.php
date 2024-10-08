<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Auth;

use Livewire\Component;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use App\Livewire\Forms\Admin\Auth\ResetPasswordForm;

#[Title('Admin Reset Password')]
#[Layout('layouts.admin.guest')]
class ResetPassword extends Component
{
    #[Locked]
    public string $token = '';

    #[Locked]
    public int $id; // User's ID

    public ResetPasswordForm $form;

    /**
     * Mount the component.
     */
    public function mount(string $token, int $id): void
    {
        $this->form->token = $token;
        $this->form->id = $id;

        $this->form->verifyToken();
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate();

        $this->form->resetPassword();

        $this->redirectRoute('admin.login', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.admin.auth.reset-password');
    }
}
