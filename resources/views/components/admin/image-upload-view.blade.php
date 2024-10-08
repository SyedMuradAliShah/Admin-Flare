@props([
'formName' => null,
'modelName' => null,
'modelVar' => null,
'currentImage' => '',
'id' => uniqid(),
'isRounded' => true,
'height' => '120px',
'width' => '120px'
])


<div class="d-inline-block mb-5">
    <div class="mb-4 position-relative image-upload image-box" onclick="document.getElementById('{{ $id }}').click();">
        @if ($modelVar)
        <img class="{{ $isRounded ? "rounded-circle":"" }} user-darg-none" src="{{ $modelVar->temporaryUrl() }}" width="{{ $width }}" height="{{ $height }}">
        @else
        <img class="{{ $isRounded ? "rounded-circle":"" }} user-darg-none" src="{{ \App\Services\ImageService::getImageUrl($currentImage) }}" alt="Image Preview" width="{{ $width }}" height="{{ $height }}" />
        @endif

        <div wire:loading wire:target="{{ $modelName }},{{ $formName }}" class="spinner-container position-absolute top-50 start-50 translate-middle justify-content-center align-items-center" style="z-index: 1; top:63px;">
            <div class="spinner-border text-success" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div class="image-overlay position-absolute top-50 start-50 translate-middle justify-content-center align-items-center bg-white {{ $isRounded ? "rounded-circle":"" }}" style="width: {{ $width }};height: {{ $height }};">
            <i class="fa-solid fa-camera fs-4 text-dark"></i>
        </div>
    </div>

    <input wire:model="{{ $modelName }}" type="file" id="{{ $id }}" accept="image/*" style="display:none;" />

    <button type="submit" wire:target="{{ $modelName }},{{ $formName }}" wire:loading.attr="disabled" class="primary-btn px-4 py-2 text-white">Save Image</button>
</div>
