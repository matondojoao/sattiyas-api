<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Repositories\Public\PostRepository;

class PostController extends Controller
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        $posts = $this->postRepository->all();

        return PostResource::collection($posts);
    }

    public function show($id)
    {
        $post = $this->postRepository->details($id);

        return new PostResource($post);
    }
}
