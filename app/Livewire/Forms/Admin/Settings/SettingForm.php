<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Admin\Settings;

use Livewire\Form;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingForm extends Form
{
    public array $key = [];

    public array $swal = [];

    public function load($settings): void
    {
        $this->key = $settings->pluck('value', 'key')->toArray();
    }

    public function rules(): array
    {
        return ['key.*' => 'nullable'];
    }

    public function save(): void
    {
        $data = [];
        foreach ($this->key as $key => $value) {
            $data[] = [
                'key' => $key,
                'value' => $value,
            ];
        }

        Setting::query()->upsert($data, ['key'], ['value']);

        // Clear the cache and update the settings
        Cache::forget('site_settings');
        $settings = Cache::rememberForever('site_settings', fn () => Setting::all()->pluck('value', 'key')->toArray());

        config(['setting' => $settings]);

        $this->swal = [
            'icon' => 'success',
            'title' => 'Settings Updated',
            'text' => 'The settings have been updated successfully.',
            'timer' => 5000,
            'bar' => true,
        ];
    }
}
