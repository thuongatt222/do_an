<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Models\OrderDetail;
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
        return new ProductCollection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $dataCreate = $request->all();
        $check = Product::where('product_name', $dataCreate['product_name'])->exists();
        if ($check) {
            return response()->json([
                'error' => 'Sản phẩm này đã tồn tại!'
            ], HttpResponse::HTTP_CONFLICT);
        }
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
        $check = Product::where('product_name', $dataUpdate['product_name'])->exists();
        if ($check) {
            return response()->json([
                'error' => 'Sản phẩm này đã tồn tại!'
            ], HttpResponse::HTTP_CONFLICT);
        }
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
        $isUsedInOtherTable = OrderDetail::where('product_id', $id)->exists();
        if ($isUsedInOtherTable) {
            return response()->json([
                'error' => 'Sản phẩm này đã tồn tại trong hóa đơn nên không thể xóa.',
            ], HttpResponse::HTTP_CONFLICT);
        }
        $product = $this->product->where('product_id', $id)->firstOrFail();
        $product->delete();
        $productResource = new ProductResource($product);
        return response()->json([
            'data' => $productResource,
        ], HttpResponse::HTTP_OK);
    }
    /**
     * Search for products by product_name.
     */
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        // Search for products with similar product_name
        $products = Product::where('product_name', 'LIKE', "%$searchTerm%")->paginate(5);
        return new ProductCollection($products);
    }
    
}
