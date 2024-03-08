<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    protected $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->product->paginate(5);
        $productsResource = ProductResource::collection($products)->response()->getData(true);
        return response()->json([
            'data' => $productsResource,
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $check =  DB::table('product')->get();
        foreach ($check as $value) {
            if ($value->product == $request->input('product')) {
                flash()->addError('Kích cỡ này đã tồn tại.');
            }
        }
        $dataCreate = $request->all();
        $product = $this->product->create($dataCreate);
        $productResource = new ProductResource($product);
        return response()->json([
            'data' => $productResource,
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
    public function update(UpdateProductRequest $request, string $id)
    {
        $product = $this->product->findOrFail($id);
       $dataUpdate = $request->all();
       $product->update($dataUpdate);
       $productResource = new ProductResource($product);
        return response()->json([
            'data' => $productResource,
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = $this->product->where('product_id', $id)->firstOrFail();
        $product->delete();
        $productResource = new ProductResource($product);
        return response()->json([
            'data' => $productResource,
        ], HttpResponse::HTTP_OK);
    }
}
