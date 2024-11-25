<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Profile;

use App\Models\Admin;
use Livewire\Component;
use Illuminate\View\View;
use Livewire\WithFileUploads;
use App\Services\ImageService;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Forms\Admin\Admins\AdminForm;
use Illuminate\Validation\ValidationException;

/**
 * @property Admin $user
 */
#[Title('Update Profile')]
#[Layout('layouts.admin.app')]
class UpdateProfile extends Component
{
    use WithFileUploads;

    public AdminForm $form;

    #[Validate(['image' => 'required|image|max:1024'])]
    public $image = '';

    public function mount(): void
    {
        $this->form->id = $this->user->id;
        $this->form->first_name = $this->user->first_name;
        $this->form->last_name = $this->user->last_name;
        $this->form->address = $this->user->address;
        $this->form->phone = $this->user->phone;
        $this->form->username = $this->user->username;
        $this->form->email = $this->user->email;
    }

    public function updatedImage(): void
    {
        try {
            $this->validateOnly('image', [
                'image' => 'image|max:1024',
            ], [
                'image.image' => 'The file must be an image.',
            ]);
        } catch (ValidationException) {
            $this->image->delete();
            $this->reset('image');

            return;
        }
    }

    public function saveImage(): void
    {
        $this->validate([
            'image' => 'required|image|max:1024',
        ], [
            'image.required' => 'A valid image is required.',
            'image.image' => 'The file must be an image.',
        ]);

        try {
            $image = ImageService::uploadImage($this->image, 'admin/profile', null);

            ImageService::deleteImage($this->user->image);

            $this->user->image = $image->filepath;

            $this->user->save();

            $this->dispatch('swal:alert', [
                'icon' => 'success',
                'title' => 'Profile Image Updated',
                'text' => 'Your profile image has been updated successfully.',
                'timer' => 5000,
                'bar' => true,
            ]);
        } catch (ValidationException) {
            $this->image->delete();
            $this->reset('image');

            $this->dispatch('swal:alert', [
                'icon' => 'error',
                'title' => 'Profile Image Update Failed',
                'text' => 'An error occurred while updating your profile image.',
                'timer' => 5000,
                'bar' => true,
            ]);

            return;
        }
    }

    public function save(): void
    {
        $this->form->validate();

        $this->form->save();

        if ($this->form->swal !== []) {
            $this->dispatch('swal:alert', $this->form->swal);

            $this->form->swal = [];

            return;
        }
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        if ($this->user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('admin.profile', absolute: false));

            return;
        }

        $this->user->sendEmailVerificationNotification();

        $this->dispatch('swal:alert', [
            'icon' => 'success',
            'title' => 'Email Verification Sent',
            'text' => 'An email verification link has been sent to your email address.',
            'timer' => 5000,
            'bar' => true,
        ]);
    }

    #[Computed]
    public function user(): ?Admin
    {
        return Auth::guard('admin')->user();
    }

    #[Computed]
    public function breadcrumb(): array
    {
        return [
            'Dashboard' => route('admin.dashboard'),
            'Profile' => route('admin.profile'),
        ];
    }

    public function render(): View
    {
        return view('livewire.admin.profile.update-profile');
    }
}
