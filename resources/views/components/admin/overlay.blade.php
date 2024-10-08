@props(['model'=>'search'])

<div wire:loading wire:loading.flex wire:target="{{ $model }}" class="position-absolute w-100 h-100 top-0 left-0 align-items-center justify-content-center bg-dark bg-opacity-50">
    <div class="spinner-border text-light" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
