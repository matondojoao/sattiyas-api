<?php

namespace App\Repositories;

use App\Models\RealStatePhotos;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PhotosRespoitory
{
    private $entity;

    public function __construct(RealStatePhotos $model)
    {
        $this->entity = $model;
    }

    public function deletePhotoById($id)
    {
        $photo = $this->entity->findOrFail($id);

        if (Storage::disk('public')->exists($photo->photo)) {
            Storage::disk('public')->delete($photo->photo);
        }
        $photo->delete();
    }
}
