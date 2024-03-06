<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Size\StoreSizeRequest;
use App\Http\Requests\Size\UpdateSizeRequest;
use App\Http\Resources\SizeConllection;
use App\Http\Resources\SizeResource;
use App\Models\size as ModelsSize;
use Flasher\Symfony\Http\Response;
use Illuminate\Console\View\Components\Task;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\DB;

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
        $sizes = $this->size->paginate(5);
        $sizesResource = SizeResource::collection($sizes)->response()->getData(true);
        return response()->json([
            'data' => $sizesResource,
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSizeRequest $request)
    {
        $check =  DB::table('sizes')->get();
        foreach ($check as $value) {
            if ($value->size == $request->input('size')) {
                flash()->addError('Kích cỡ này đã tồn tại.');
            }
        }
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
        //
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