<?php

namespace App\Http\Controllers;

use App\Http\Requests\Size\StoreSizeRequest;
use App\Http\Requests\Size\UpdateSizeRequest;
use App\Http\Resources\Size\SizeResource;
use App\Models\size as ModelsSize;
use Illuminate\Http\Response as HttpResponse;

class SizeController extends Controller
{
    protected $size;
    public function __construct(ModelsSize $size)
    {
        $this->size = $size;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $size = $this->size->paginate(5);
        $sizesResource = SizeResource::collection($size)->response()->getData(true);
        return response()->json([
            'data' => $sizesResource,
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSizeRequest $request)
    {
        $dataCreate = $request->all();
        $size = $this->size->create($dataCreate);
        $sizeResource = new SizeResource($size);
        return response()->json([
            'data' => $sizeResource,
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
    public function update(UpdateSizeRequest $request, string $id)
    {
       $size = $this->size->findOrFail($id);
       $dataUpdate = $request->all();
       $size->update($dataUpdate);
       $sizeResource = new SizeResource($size);
        return response()->json([
            'data' => $sizeResource,
        ], HttpResponse::HTTP_OK);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $size = $this->size->where('size_id', $id)->firstOrFail();
        $size->delete();
        $sizeResource = new SizeResource($size);
        return response()->json([
            'data' => $sizeResource,
        ], HttpResponse::HTTP_OK);
    }
}