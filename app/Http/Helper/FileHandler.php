<?php

namespace App\Http\Controllers\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class FileHandler
{
    public static function upload($image, $path, $size = null, $prefix = null)
    {
        $prefix = isset($prefix) ? $prefix : time();

        $image_name = $prefix . '-' . $size['width'] . 'x' . $size['height'] . '-' . $image->getClientOriginalName();

        $image_path = "uploads/$path/$image_name";

        $resized_image = Image::make($image)->resize($size['width'], $size['height'])->stream();

        Storage::disk('public')->put($image_path, $resized_image);
        return $image_path;
    }

    public static function delete($path)
    {
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
    }
}
