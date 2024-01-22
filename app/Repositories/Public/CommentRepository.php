<?php

namespace App\Repositories\Public;

use App\Models\Comment;

class CommentRepository
{
    private $entity;

    public function __construct(Comment $model)
    {
        $this->entity = $model;
    }

    public function create(array $data)
    {
        return $this->entity->create($data);
    }
}
