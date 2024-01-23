<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Repositories\Admin\PostRepository;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $post = $this->postRepository->create($data);

        return $post;
        //return new PostResource($post);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $post = $this->postRepository->update($id, $data);

        return new PostResource($post);
    }

    public function destroy($id)
    {
        return $this->postRepository->delete($id);
    }
}
