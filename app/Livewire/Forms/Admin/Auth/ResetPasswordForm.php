<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Admin\Auth;

use Livewire\Form;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Str;
use Livewire\Attributes\Locked;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\ValidationException;

class ResetPasswordForm extends Form
{
    #[Locked]
    public string $token = '';

    #[Locked]
    public int $id;

    public string $password = '';

    public string $password_confirmation = '';

    public function rules(): array
    {
        return [
            'token' => ['required'],
            'id' => ['required', 'integer', 'exists:admins,id'],
            'password' => ['required', 'string', Rules\Password::defaults()],
            'password_confirmation' => ['required', 'same:password', Rules\Password::defaults()],
        ];
    }

    /**
     * Mount the component.
     */
    public function verifyToken(): void
    {

        $admin = Admin::query()->findOrFail($this->id);

        abort_unless(Password::broker('admins')->tokenExists($admin, $this->token), 404);
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $status = Password::broker('admins')->reset(
            $this->only('id', 'password', 'password_confirmation', 'token'),
            function (Admin $user): void {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        throw_if($status !== Password::PASSWORD_RESET, ValidationException::withMessages([
            'form.error' => (is_string($status) ? $status : 'auth.failed'),
        ]));
    }
}
