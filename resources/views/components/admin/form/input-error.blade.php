@props(['messages'])

@if ($messages)
@foreach ((array) $messages as $message)
<div {{ $attributes->merge(['class' => 'text-danger']) }}>
    {{ $message }}
</div>
@endforeach
@endif
