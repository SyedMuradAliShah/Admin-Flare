@props(['breadcrumb' => []])

@if(!empty($breadcrumb))
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @foreach ($breadcrumb as $label => $url)
        <li class="breadcrumb-item small {{ $loop->last ? 'active' : '' }}" {{ $loop->last ? 'aria-current="page"' : '' }}>
            @if (!$loop->last)
            <a href="{{ $url }}" wire:navigate>{{ $label }}</a>
            @else
            {{ $label }}
            @endif
        </li>
        @endforeach
    </ol>
</nav>
@endif