<?php

namespace App\Repositories\Admin;

use App\Models\Comment;

class CommentRepository
{
    private $entity;

    public function __construct(Comment $model)
    {
        $this->entity = $model;
    }

    public function update(string $id, array $data)
    {
        $comment = $this->entity->findOrFail($id);
        $comment->update($data);

        return $comment;
    }

    public function delete($id)
    {
        $comment = $this->entity->findOrFail($id);
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
