@props(['model'=>'search', 'placeholder' => 'Search...'])

<div class="d-flex justify-content-end align-items-center gap-2 position-relative">
    <input type="text" wire:model.live.debounce.250ms="{{ $model }}" class="form-control w-auto py-2 ps-2 pe-4" placeholder="{{ $placeholder }}">
    <div class="position-absolute top-50 end-0 translate-middle-y border-0 bg-transparent pe-2">
        <i wire:loading.class="d-none" wire:target="{{ $model }}" class="fa-solid fa-magnifying-glass"></i>
        <i wire:loading wire:target="{{ $model }}" class="fa-solid fa-sync fa-spin"></i>
    </div>
</div>
