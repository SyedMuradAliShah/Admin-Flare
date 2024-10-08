<a {{ $attributes->merge(['class' => 'bg-opacity-10 small rounded-circle text-decoration-none', 'data-bs-placement'=>'top']) }} data-bs-toggle="tooltip" wire:navigate>
    {{ $slot }}
</a>
