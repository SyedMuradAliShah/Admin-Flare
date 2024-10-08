<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Admin\Auth;

use Livewire\Form;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class ForgotPasswordForm extends Form
{
    #[Validate('required|string|email')]
    public string $email = '';

    public array $swal = [];

    public function restPassword(): void
    {
        $this->ensureIsNotRateLimited();

        $status = Password::broker('admins')->sendResetLink(
            $this->only('email'),
        );

        $this->reset('email');

        throw_if($status !== Password::RESET_LINK_SENT, ValidationException::withMessages([
            'form.email' => __($status),
        ]));

        $this->swal = [
            'icon' => 'success',
            'title' => 'Password Reset Link Sent',
            'text' => __($status),
        ];

    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'form.email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}
