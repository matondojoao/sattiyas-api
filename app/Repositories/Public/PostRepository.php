<?php

namespace App\Repositories\Public;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Traits\TraitRepository;

class PostRepository
{
    private $entity;
    use TraitRepository;

    public function __construct(Post $model)
    {
        $this->entity = $model;
    }

    public function all()
    {
        return $this->entity->all();
    }

    public function details($id)
    {
        return $this->entity->with('comments')->findOrFail($id);
    }
}
