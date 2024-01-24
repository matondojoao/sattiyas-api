<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Repositories\Public\PostRepository;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index(Request $request)
    {
        $data = $request->all();
        $posts = $this->postRepository->all($data);

        return PostResource::collection($posts);
    }

    public function show($slug)
    {
        $post = $this->postRepository->details($slug);

        return new PostResource($post);
    }
}
