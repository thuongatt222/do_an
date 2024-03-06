<?php

namespace App\Http\Controllers;

use App\Http\Requests\Brand\StoreBrandRequest;
use App\Http\Requests\Brand\UpdateBrandRequest;
use App\Http\Resources\Brand\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;


class BrandController extends Controller
{
    protected $brand;
    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }
    public function index()
    {
        $brands = $this->brand->paginate(5);
        $brandsResource = BrandResource::collection($brands)->response()->getData(true);
        return response()->json([
            'data' => $brandsResource,
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        $dataCreate = $request->all();
        $brand = $this->brand->create($dataCreate);
        $brandResource = new BrandResource($brand);
        return response()->json([
            'data' => $brandResource,
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, string $id)
    {
        $brand = $this->brand->findOrFail($id);
        $dataUpdate = $request->all();
        $brand->update($dataUpdate);
        $brandResource = new BrandResource($brand);
        return response()->json([
            'data' => $brandResource,
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = $this->brand->where('size_id', $id)->firstOrFail();
        $brand->delete();
        $brandResource = new BrandResource($brand);
        return response()->json([
            'data' => $brandResource,
        ], HttpResponse::HTTP_OK);
    }
}
