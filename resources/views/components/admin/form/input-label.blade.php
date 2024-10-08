@props(['value'])

<label {{ $attributes->merge(['class' => 'form-label mb-2 text-muted']) }}>
    {{ $value ?? $slot }}
</label>