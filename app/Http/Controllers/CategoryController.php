<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
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
        $category = $this->category->where('category_id', $id)->firstOrFail();
        $category->delete();
        $categoryResource = new CategoryResource($category);
        return response()->json([
            'data' => $categoryResource,
        ], HttpResponse::HTTP_OK);
    }
}
