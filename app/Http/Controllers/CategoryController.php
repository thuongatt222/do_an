<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

class CategoryController extends Controller
{
    protected $category;
    public function __construct(Category $category)
    {
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorys = $this->category->paginate(5);
        $categorysResource = CategoryResource::collection($categorys)->response()->getData(true);
        return response()->json([
            'data' => $categorysResource,
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category_name = $request->input('category_name');
        $check = Category::where('category_name', $category_name)->exists();
        if ($check) {
            return response()->json([
                'error' => 'Tên thể loại này đã tồn tại.'
            ], HttpResponse::HTTP_CONFLICT);
        }
        $dataCreate = $request->all();
        $category = $this->category->create($dataCreate);
        $categoryResource = new CategoryResource($category);
        return response()->json([
            'data' => $categoryResource,
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
    public function update(UpdateCategoryRequest $request, string $id)
    {
        $category = $this->category->findOrFail($id);
        $dataUpdate = $request->all();
        $check = Category::where('brand_name', $dataUpdate['brand_name'])->exists();
        if ($check) {
            return response()->json([
                'error' => 'Tên thể loại này đã tồn tại!',
            ], HttpResponse::HTTP_CONFLICT);
        }
        $category->update($dataUpdate);
        $categoryResource = new CategoryResource($category);
        return response()->json([
            'data' => $categoryResource,
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $isUsedInOtherTable = Product::where('category_id', $id)->exists();
        if ($isUsedInOtherTable) {
            return response()->json([
                'error' => 'Thể loại này đang có sản phẩm nên không thể xóa.',
            ], HttpResponse::HTTP_CONFLICT);
        }
        $category = $this->category->where('category_id', $id)->firstOrFail();
        $category->delete();
        $categoryResource = new CategoryResource($category);
        return response()->json([
            'data' => $categoryResource,
        ], HttpResponse::HTTP_OK);
    }
}
