<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Admin\Auth;

use Livewire\Form;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

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

        if (Auth::guard('admin')->attempt($this->getCredentials(), $this->remember)) {
            $this->handleSuccessfulLogin();
            return;
        }

        $this->handleFailedLogin();
    }

    private function getCredentials(): array
    {
        return [
            'password' => $this->password,
            function (Builder $query) {
                $query->where('email', $this->email);
                
                if ($this->hasUsernameColumn()) {
                    $query->orWhere('username', $this->email);
                }
            }
        ];
    }

    private function hasUsernameColumn(): bool
    {
        return Schema::hasColumn('admins', 'username');
    }

    private function handleSuccessfulLogin(): void
    {
        $this->swal = [
            'icon' => 'success',
            'title' => 'Login Successful',
            'text' => 'You have been logged in successfully!',
            'url' => route('admin.dashboard'),
            'timer' => 1000,
        ];

        RateLimiter::clear($this->throttleKey());
    }

    private function handleFailedLogin(): void
    {
        RateLimiter::hit($this->throttleKey());

        $this->swal = [
            'icon' => 'error',
            'title' => 'Login Failed',
            'text' => trans('auth.failed'),
        ];

        $this->reset('password');
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
