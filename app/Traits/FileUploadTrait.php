<?php

namespace App\Traits;

use Illuminate\Http\Request;
use File;

trait FileUploadTrait
{
    public function handleFileUpload(Request $request, string $fieldName, ?string $oldpath = null, string $dir = 'uploads'): ?String
    {

        /** Check request has file */
        if (!$request->hasFile($fieldName)) {
            return null;
        }

        /** Delete the existing image if have */
        if ($oldpath && File::exists(public_path($oldpath))) {
            File::delete(public_path($oldpath));
        }

        $file = $request->file($fieldName);
        $extension = $file->getClientOriginalExtension();
        $updatedFileName = \Str::random(30) . '.' . $extension;

        $file->move(public_path($dir), $updatedFileName);

        $filePath = $dir . '/' . $updatedFileName;  // uploads/filename.jpg

        return $filePath;
    }

    public function deleteFile(string $path) : void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
