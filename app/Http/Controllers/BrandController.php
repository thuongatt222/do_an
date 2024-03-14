<?php

namespace App\Http\Controllers;

use App\Http\Requests\Brand\StoreBrandRequest;
use App\Http\Requests\Brand\UpdateBrandRequest;
use App\Http\Resources\Brand\BrandCollection;
use App\Http\Resources\Brand\BrandResource;
use App\Models\Brand;
use App\Models\Product;
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
        $brandsResource = new BrandCollection($brands);
        return $brandsResource;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        $brand_name = $request->input('brand_name');
        $check = Brand::where('brand_name', $brand_name)->exists();
        if ($check) {
            return response()->json([
                'error' => 'Tên nhẫn hàng này đã tồn tại.'
            ], HttpResponse::HTTP_CONFLICT);
        } else {
            $dataCreate = $request->all();
            $brand = $this->brand->create($dataCreate);
            $brandResource = new BrandResource($brand);
            return response()->json([
                'data' => $brandResource,
            ], HttpResponse::HTTP_OK);
        }
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
        $check = Brand::where('brand_name', $dataUpdate['brand_name'])->exists();
        if ($check) {
            return response()->json([
                'error' => 'Tên thương hiệu này đã tồn tại!',
            ], HttpResponse::HTTP_CONFLICT);
        }
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
        $isUsedInOtherTable = Product::where('brand_id', $id)->exists();
        if ($isUsedInOtherTable) {
            return response()->json([
                'error' => 'Nhãn hành này đang có sản phẩm nên không thể xóa.',
            ], HttpResponse::HTTP_CONFLICT);
        }
        $brand = $this->brand->where('brand_id', $id)->firstOrFail();
        $brand->delete();
        $brandResource = new BrandResource($brand);
        return response()->json([
            'data' => $brandResource,
        ], HttpResponse::HTTP_OK);
    }
}
