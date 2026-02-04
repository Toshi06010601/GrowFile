<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Exception;

trait HasImageUpload
{
    public function uploadNewImage(UploadedFile $file, string $folder, ?string $oldPath = null) : string
    {
        try {
            $path = $file->store(path: $folder);
    
            if (!$path) {
                throw new Exception('Failed to store new image');
            }
    
            logger()->info('New image uploaded', ['path' => $path]);
    
            return $path;

        } catch(Exception $e) {
            logger()->error('Image upload failed', [
                'error' => $e->getMessage(),
                'folder' => $folder
            ]);

            throw $e;
        }
    }

    public function deleteOldImage(?string $oldPath, string $exceptionFilePath) : void
    {
        if (!$oldPath || str_contains($oldPath, $exceptionFilePath)) {
            return;
        }

        try {
            if(Storage::disk('public')->exists($oldPath)){
                Storage::disk('public')->delete($oldPath);
                logger()->info('Old image deleted', ['path' => $oldPath ]);
            }
        } catch (Exception $e) {
            logger()->warning('Failed to delete old image', [
                'path' => $oldPath,
                'error' => $e->getMessage()
            ]);
        }
    }


}
