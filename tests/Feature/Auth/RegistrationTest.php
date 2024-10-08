<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use Livewire\Livewire;
use App\Livewire\Pages\Auth\Register;

test('registration screen can be rendered', function (): void {
    $response = $this->get('/register');

    $response
        ->assertOk()
        ->assertSeeLivewire(Register::class);
});

test('new users can register', function (): void {
    $component = Livewire::test(Register::class)
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('password', 'password')
        ->set('password_confirmation', 'password');

    $component->call('register');

    $component->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});
