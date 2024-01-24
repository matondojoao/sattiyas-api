<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Resources\TagResource;
use App\Repositories\Admin\TagRepository;
use Illuminate\Http\Request;

class TagController extends Controller
{
    protected $TagRepository;

    public function __construct(TagRepository $TagRepository)
    {
        $this->TagRepository = $TagRepository;
    }

    public function store(StoreTagRequest $request)
    {
        $data = $request->validated();
        $tag = $this->TagRepository->create($data);

        return new TagResource($tag);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $tag = $this->TagRepository->update($id, $data);

        return new TagResource($tag);
    }

    public function destroy($id)
    {
        return $this->TagRepository->delete($id);
    }
}
