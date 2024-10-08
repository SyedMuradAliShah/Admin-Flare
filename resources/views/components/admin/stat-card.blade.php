@props(['title' => "Your Card Title", 'count' => 0, 'icon' => 'fa-solid fa-circle-info'])

<div class="col mb-4">
    <div {{ $attributes->merge(['class'=>'cardbox box1 p-4 position-relative rounded-3']) }}>
        <h6 class="">{{ $title }}</h6>
        <h5 class="fw-bold">{{ $count }}</h5>
        <div class="icon d-flex justify-content-center align-items-center">
            <i class="{{ $icon }} fs-3 text-white"></i>
        </div>
    </div>
</div>
