<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Settings;

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\View\View;
use Livewire\WithFileUploads;
use App\Services\ImageService;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Illuminate\Validation\ValidationException;
use App\Livewire\Forms\Admin\Settings\SettingForm;

#[Title('Manage Settings')]
#[Layout('layouts.admin.app')]
class ManageSettings extends Component
{
    use WithFileUploads;

    public SettingForm $form;

    #[Validate(['logo' => 'required|image|max:1024'])]
    public $logo = '';

    #[Validate(['favicon' => 'required|image|max:1024'])]
    public $favicon = '';
    
    private string $guardName = 'admin'; // Guard name

    public function mount(): void
    {
        $this->authorize('view:settings', Auth::guard($this->guardName)->user());

        $this->form->load($this->settings);
    }

    public function updatedLogo(): void
    {
        $this->authorize('update:settings', Auth::guard($this->guardName)->user());

        try {
            $this->validateOnly('logo', [
                'logo' => 'image|max:1024',
            ], [
                'logo.logo' => 'The file must be an image.',
            ]);
        } catch (ValidationException) {
            if ($this->logo instanceof TemporaryUploadedFile) {
                $this->logo->delete();
            }

            $this->reset('logo');

            return;
        }
    }

    public function saveLogo(): void
    {
        $this->authorize('update:settings', Auth::guard($this->guardName)->user());

        $this->validate([
            'logo' => 'required|image|max:1024',
        ], [
            'logo.required' => 'A valid image is required.',
            'logo.image' => 'The file must be an image.',
        ]);

        try {
            $image = ImageService::uploadImage($this->logo, resize: [260, 104]);

            ImageService::deleteImage($this->form->key['site_general_logo']);

            $this->form->key['site_general_logo'] = $image->filepath;

            $this->form->save();

            $this->dispatch('swal:alert', [
                'icon' => 'success',
                'title' => 'Logo Image Updated',
                'text' => 'Your logo image has been updated successfully.',
                'timer' => 5000,
                'bar' => true,
            ]);
        } catch (ValidationException) {
            if ($this->logo instanceof TemporaryUploadedFile) {
                $this->logo->delete();
            }

            $this->reset('logo');

            $this->dispatch('swal:alert', [
                'icon' => 'error',
                'title' => 'Logo Update Failed',
                'text' => 'An error occurred while updating your logo image.',
                'timer' => 5000,
                'bar' => true,
            ]);

            return;
        }
    }

    public function updatedFavicon(): void
    {
        $this->authorize('update:settings', Auth::guard($this->guardName)->user());

        try {
            $this->validateOnly('favicon', [
                'favicon' => 'image|max:1024',
            ], [
                'favicon.favicon' => 'The file must be an image.',
            ]);
        } catch (ValidationException) {
            if ($this->favicon instanceof TemporaryUploadedFile) {
                $this->favicon->delete();
            }

            $this->reset('favicon');

            return;
        }
    }

    public function saveFavicon(): void
    {
        $this->authorize('update:settings', Auth::guard($this->guardName)->user());

        $this->validate([
            'favicon' => 'required|image|max:1024',
        ], [
            'favicon.required' => 'A valid image is required.',
            'favicon.image' => 'The file must be an image.',
        ]);

        try {
            $image = ImageService::uploadImage($this->favicon, resize: [180, 100]);

            ImageService::deleteImage($this->form->key['site_general_favicon']);

            $this->form->key['site_general_favicon'] = $image->filepath;

            $this->form->save();

            $this->dispatch('swal:alert', [
                'icon' => 'success',
                'title' => 'Favicon Image Updated',
                'text' => 'Your favicon image has been updated successfully.',
                'timer' => 5000,
                'bar' => true,
            ]);
        } catch (ValidationException) {
            if ($this->favicon instanceof TemporaryUploadedFile) {
                $this->favicon->delete();
            }

            $this->reset('favicon');

            $this->dispatch('swal:alert', [
                'icon' => 'error',
                'title' => 'Favicon Update Failed',
                'text' => 'An error occurred while updating your favicon image.',
                'timer' => 5000,
                'bar' => true,
            ]);

            return;
        }
    }

    public function save(): void
    {
        $this->authorize('update:settings', Auth::guard($this->guardName)->user());

        $this->form->validate();

        $this->form->save();

        if ($this->form->swal !== []) {
            $this->dispatch('swal:toast', $this->form->swal);

            $this->form->swal = [];

            return;
        }
    }

    #[Computed]
    public function settings()
    {
        return Setting::query()->first();
    }

    #[Computed]
    public function breadcrumb(): array
    {
        return [
            'Dashboard' => route('admin.dashboard'),
            'Settings' => route('admin.settings.index'),
        ];
    }

    public function render(): View
    {
        return view('livewire.admin.settings.manage-settings');
    }
}
