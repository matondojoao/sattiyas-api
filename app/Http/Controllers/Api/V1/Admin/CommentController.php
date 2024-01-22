<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Repositories\Admin\CommentRepository;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $comment = $this->commentRepository->update($id, $data);

        return new CommentResource($comment);
    }

    public function destroy($id)
    {
        return $this->commentRepository->delete($id);
    }
}
