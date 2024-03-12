<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductDetail\StoreProductDetailRequest;
use App\Http\Requests\ProductDetail\UpdateProductDetailRequest;
use App\Http\Resources\ProductDetail\ProductDetailResource;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\size;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

class ProductDetailController extends Controller
{
    protected $product_detail;
    public function __construct(ProductDetail $product_detail)
    {
        $this->product_detail = $product_detail;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product_details = $this->product_detail->paginate(5);
        $product_detailsResource = ProductDetailResource::collection($product_details)->response()->getData(true);
        return response()->json([
            'data' => $product_detailsResource,
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductDetailRequest $request)
    {
        $dataCreate = $request->all();
        $check = ProductDetail::where('color_id', $dataCreate['color_id'])
            ->where('product_id', $dataCreate['product_id'])
            ->where('size_id', $dataCreate['size_id'])->exists();
        if($check){
            return response()->json([
                'error' => 'Sản phẩm này đã tồn tại'
            ], HttpResponse::HTTP_CONFLICT);
        }
        $product_detail = $this->product_detail->create($dataCreate);
        $product_detailResource = new ProductDetailResource($product_detail);
        return response()->json([
            'data' => $product_detailResource,
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductDetailRequest $request, string $id)
    {
        $product_detail = $this->product_detail->findOrFail($id);
        $dataUpdate = $request->all();
        $check = ProductDetail::where('color_id', $dataUpdate['color_id'])
            ->where('product_id', $dataUpdate['product_id'])
            ->where('size_id', $dataUpdate['size_id'])->exists();
        if($check){
            return response()->json([
                'error' => 'Sản phẩm này đã tồn tại'
            ], HttpResponse::HTTP_CONFLICT);
        }
        $product_detail->update($dataUpdate);
        $product_detailResource = new ProductDetailResource($product_detail);
        return response()->json([
            'data' => $product_detailResource,
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product_detail = $this->product_detail->where('product_detail_id', $id)->firstOrFail();
        $product_detail->delete();
        $product_detailResource = new ProductDetailResource($product_detail);
        return response()->json([
            'data' => $product_detailResource,
        ], HttpResponse::HTTP_OK);
    }
}
