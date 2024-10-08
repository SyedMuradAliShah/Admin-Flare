<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use Livewire\Livewire;
use Illuminate\Support\Facades\Hash;
use App\Livewire\Profile\UpdatePasswordForm;

test('password can be updated', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user);

    $component = Livewire::test(UpdatePasswordForm::class)
        ->set('current_password', 'password')
        ->set('password', 'new-password')
        ->set('password_confirmation', 'new-password')
        ->call('updatePassword');

    $component
        ->assertHasNoErrors()
        ->assertNoRedirect();

    $this->assertTrue(Hash::check('new-password', $user->refresh()->password));
});

test('correct password must be provided to update password', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user);

    $component = Livewire::test(UpdatePasswordForm::class)
        ->set('current_password', 'wrong-password')
        ->set('password', 'new-password')
        ->set('password_confirmation', 'new-password')
        ->call('updatePassword');

    $component
        ->assertHasErrors(['current_password'])
        ->assertNoRedirect();
});
