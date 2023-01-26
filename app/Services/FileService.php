<?php

namespace App\Services;

class FileService
{
    /**
     * @param $file
     * @param string $dir_name
     * @return string
     */
    public static function uploadImageToCloud($file, $dir_name = 'properties') {
        $base_path = config('app.env') . '/' . $dir_name . '/' . auth()->id();
        $path = $file->storePublicly($base_path, 'digitalocean');
        return  \Storage::disk('digitalocean')->url($path);
    }

    /**
     * @param $file
     * @param string $dir_name
     * @return string
     */
    public static function uploadImageLocally($file, $dir_name = 'properties') {
        $extension = $file->extension();
        $file_name = time() . '_' . \Str::random(8) . '.' . $extension;
        $base_path = config('app.env') . '/' . $dir_name . '/' . auth()->id();
        $file->storeAs($base_path, $file_name, 'public');
        return $base_path .'/'. $file_name;
    }

    /**
     * @param $file_path
     * @param string $dir_name
     * @return void
     */
    public static function deleteCloudImage($file_path, $dir_name = 'properties') {
        $image = config('app.env') . '/' . $dir_name . '/' . auth()->id() . '/' . last(explode('/', $file_path));
        \Storage::disk('digitalocean')->delete($image);
    }
}
