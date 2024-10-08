<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Admin\Auth;

use Livewire\Form;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginForm extends Form
{
    #[Validate('required|string')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    #[Validate('boolean')]
    public bool $remember = false;

    public array $swal = [];

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::guard('admin')->attempt($this->credentials(), remember: $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            $this->swal = [
                'icon' => 'error',
                'title' => 'Login Failed',
                'text' => trans('auth.failed'),
            ];

            $this->reset('password');

            return;
        }

        $this->swal = [
            'icon' => 'success',
            'title' => 'Login Successful',
            'text' => 'You have been logged in successfully!',
            'url' => route('admin.dashboard'),
            'timer' => 1000,
        ];

        RateLimiter::clear($this->throttleKey());
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

    private function credentials(): array
    {
        $user_type = Validator::make(
            ['email' => $this->email],
            [
                'email' => 'required|string|email',
            ],
        )->passes() ? 'email' : 'username';

        return [
            $user_type => $this->email,
            'password' => $this->password,
        ];

    }
}
