<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Admin\Admins;

use Livewire\Form;
use App\Models\Admin;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminForm extends Form
{
    public ?int $id = null;

    public string $first_name = '';

    public string $last_name = '';

    public string $address = '';

    public string $phone = '';

    public string $username = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public array $swal = [];

    public function rules(): array
    {
        $uniqueIgnore = Rule::unique(Admin::class)->ignore($this->id);

        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', $uniqueIgnore],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', $uniqueIgnore],

            // Password rules only apply when creating or updating with a new password
            'password' => ['nullable', 'confirmed', 'string', Password::defaults()],
            'password_confirmation' => ['nullable', 'same:password', Password::defaults()],
        ];
    }

    /**
     * Save or update the admin details.
     */
    public function save(): void
    {
        $validated = $this->validate();

        $admin = Admin::query()->findOrNew($this->id);

        $admin->fill(Arr::except($validated, ['password', 'password_confirmation']));

        if ($this->password !== '' && $this->password !== '0') {
            $admin->password = Hash::make($this->password);
        }

        if ($admin->isDirty('email')) {
            $admin->email_verified_at = null;
        }

        $admin->save();

        $this->setSweetAlertMessage($this->id !== null && $this->id !== 0 ? 'Profile Updated' : 'Admin Created');

        $this->reset(['password', 'password_confirmation']);
    }

    /**
     * Set SweetAlert data with a success message.
     */
    private function setSweetAlertMessage(string $title): void
    {
        $this->swal = [
            'icon' => 'success',
            'title' => $title,
            'text' => $this->id !== null && $this->id !== 0
                ? 'The profile has been updated successfully.'
                : 'A new admin has been created successfully.',
            'timer' => 3000,
            'bar' => true,
            'reload' => true,
        ];
    }
}
