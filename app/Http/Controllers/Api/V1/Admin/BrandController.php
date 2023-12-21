<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Resources\BrandResource;
use App\Repositories\Admin\BrandRepository;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    protected $BrandRepository;

    public function __construct(BrandRepository $BrandRepository)
    {
        $this->BrandRepository = $BrandRepository;
    }

    public function store(StoreBrandRequest $request)
    {
        $data = $request->validated();
        $brand = $this->BrandRepository->create($data);

        return new BrandResource($brand);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $brand = $this->BrandRepository->update($id, $data);

        return new BrandResource($brand);
    }

    public function destroy($id)
    {
        return $this->BrandRepository->delete($id);
    }
}
