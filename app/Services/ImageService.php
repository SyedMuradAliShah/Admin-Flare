<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class ImageService
{
    /**
     * Get the URL of an image if it exists, otherwise return a default image URL.
     *
     * @param  string|null  $path  The image path (relative to the disk).
     * @param  string  $disk  The storage disk to check (default is 'public').
     * @param  string  $default  The default image URL or path to use if the image doesn't exist.
     */
    public static function getImageUrl(?string $path = '', string $disk = 'public', string $default = 'assets/images/no-image.webp') : string
    {
        $path = trim($path ?? '', '/');

        if (empty($path))
        {
            return asset($default);
        }

        $cacheKey = "image_url_{$disk}_{$path}";

        // Return the cached URL if it exists
        return Cache::remember($cacheKey, 60 * 60 * 24, function () use ($disk, $path, $default)
        {
            $fullPath = Storage::disk($disk)->path($path);

            if (is_file($fullPath) && file_exists($fullPath) && Storage::disk($disk)->exists($path))
            {
                return asset("uploads/{$path}");
            }

            return asset($default);
        });
    }

    /**
     * Delete an image from the storage disk.
     *
     * @param  string|null  $path  The image path (relative to the disk).
     * @param  string  $disk  The storage disk to delete the image from (default is 'public').
     */
    public static function deleteImage(?string $path = '', string $disk = 'public') : void
    {
        // Ensure the path is not empty and is targeting a specific file
        $path     = trim($path ?? '', '/');
        $fullPath = Storage::disk($disk)->path($path);

        // Check if the path is a valid file and not a directory
        if ($path && is_file($fullPath) && file_exists($fullPath))
        {
            Storage::disk($disk)->delete($path);
        }
    }

    /**
     * Upload an image to the storage disk.
     *
     * @param  $image  The image file to upload.
     * @param  string  $directory  The directory to store the image in (default is 'images').
     * @param  array|null  $resize  The dimensions to resize the image to, in [width, height] (null to skip resizing).
     * @param  string  $disk  The storage disk to upload the image to (default is 'public').
     * @param  bool  $forceScale  To force a any image to be scale fit.
     * @return object Returns an array containing the 'path' and 'filename' of the uploaded image.
     */
    public static function uploadImage($image, string $directory = 'images', ?array $resize = [ 450, 450 ], bool $forceScale = false, string $disk = 'public') : object
    {
        $directory = trim($directory, '/');

        $extension = $image->getClientOriginalExtension();

        $filename = Str::uuid() . '.' . $extension;

        $filepath = sprintf('%s/%s', $directory, $filename);

        $imageManager = ImageManager::withDriver(Driver::class);

        $image->getClientOriginalExtension();

        $processedImage = $imageManager->read($image->getRealPath());

        if ($resize !== null && $forceScale)
        {
            $processedImage->resize($resize[0], $resize[1]);
        }
        elseif ($resize !== null)
        {
            $processedImage->resizeDown($resize[0], $resize[1]);
        }

        $encodedImage = $processedImage->encode();

        Storage::disk($disk)->put($filepath, $encodedImage);

        return (object) [
            'directory' => $directory,
            'filename'  => $filename,
            'filepath'  => $filepath,
        ];
    }
}
