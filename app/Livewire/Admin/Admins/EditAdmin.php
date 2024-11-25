<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Admins;

use App\Models\Admin;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\ImageService;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Forms\Admin\Admins\AdminForm;
use Illuminate\Validation\ValidationException;

#[Title('Admins')]
#[Layout('layouts.admin.app')]

class EditAdmin extends Component
{
    use WithFileUploads;

    public AdminForm $form;

    #[Locked]
    public $admin;

    #[Validate(['image' => 'required|image|max:1024'])]
    public $image = '';

    public $user;

    private string $guardName = 'admin'; // Guard name

    public function mount()
    {
        $this->authorize('update:admin', Auth::guard($this->guardName)->user());

        $this->user = $this->user();

        if ($this->user->id === Auth::guard($this->guardName)->id()) {
            return $this->redirect(route('admin.profile'), navigate: true);
        }

        $this->form->id = $this->user->id;
        $this->form->first_name = $this->user->first_name;
        $this->form->last_name = $this->user->last_name;
        $this->form->address = $this->user->address;
        $this->form->phone = $this->user->phone;
        $this->form->username = $this->user->username;
        $this->form->email = $this->user->email;

        return null;

    }

    public function updatedImage(): void
    {
        $this->authorize('update:admin', Auth::guard($this->guardName)->user());

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
        $this->authorize('update:admin', Auth::guard($this->guardName)->user());

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
                'text' => 'The profile image has been successfully updated.',
                'timer' => 5000,
                'bar' => true,
            ]);
        } catch (ValidationException) {
            $this->image->delete();
            $this->reset('image');

            return;
        }
    }

    public function save(): void
    {
        $this->authorize('update:admin', Auth::guard($this->guardName)->user());

        $this->form->validate();

        $this->form->save();

        if ($this->form->swal !== []) {
            $this->dispatch('swal:alert', $this->form->swal);

            $this->form->swal = [];

            return;
        }
    }

    #[Computed]
    public function user(): ?Admin
    {
        return Admin::query()->findOrFail($this->admin);
    }

    #[Computed]
    public function breadcrumb(): array
    {
        return [
            'Dashboard' => route('admin.dashboard'),
            'Admins' => route('admin.admins.index'),
            'Edit Admin' => '',
        ];
    }

    public function render()
    {
        return view('livewire.admin.admins.edit-admin');
    }
}
