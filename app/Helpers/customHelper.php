<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use Intervention\Image\ImageManager as ImageManager;
use Intervention\Image\Drivers\GD\Driver as Driver;

use App\Models\SavePermissionModel;


function isPermissions($permission){
    $permission_id = DB::table('user_permissions')->where('tle', $permission)->value('upi');
    $UserPermissions = SavePermissionModel::where('user_role',Auth::user()->user_role)->where('permission',$permission_id)->exists();
    return $UserPermissions;
}


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

// delete Image
function deleteImage($imagePath)
{
    // Define the full path to the image
    $fullPath = public_path('images/' . $imagePath);

    // Check if the file exists and delete it
    if (File::exists($fullPath)) {
        File::delete($fullPath);
        return true;
    }

    return false;
}
