@props(['id'=>null])

<a {{ $attributes->merge(['class' => 'bg-danger-subtle text-danger bg-opacity-10 small rounded-circle text-decoration-none delete', 'data-bs-placement'=>'top']) }} data-bs-toggle="tooltip" data-id="{{ $id }}" wire:navigate>
    {{ $slot }}
</a>
