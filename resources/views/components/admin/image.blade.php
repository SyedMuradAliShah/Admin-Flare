@props(['image'])
<img src="{{ \App\Services\ImageService::getImageUrl($image) }}" {{ $attributes }} />
