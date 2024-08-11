<?php

use Illuminate\Support\Facades\Storage;

use Intervention\Image\ImageManager as ImageManager;
use Intervention\Image\Drivers\GD\Driver as Driver;

function saveImage($file)
{
    try {
        if (!$file->isValid()) {
            throw new \Exception('Invalid file uploaded.');
        }
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $path = public_path('images/' . $fileName);
        $file->move(public_path('images'), $fileName);
        return $fileName;
    } catch (\Exception $e) {
        return null;
    }
}


function saveImageWebp($file)
{
    try {

        if (!$file->isValid()) {
            throw new \Exception('Invalid file uploaded.');
        }

        $fileName = uniqid() . '.webp';
        $path = public_path('images/' . $fileName);

        $manager = new ImageManager(new Driver());
        $image = $manager->read($file->getRealPath());
        $image->toWebp(quality: 90)->save($path);

        return $fileName;

    } catch (\Exception $e) {
        return null;
    }

}
