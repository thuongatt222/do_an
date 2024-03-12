<?php

namespace App\Http\Controllers;

use App\Http\Requests\Color\StoreColorRequest;
use App\Http\Requests\Color\UpdateColorRequest;
use App\Http\Resources\Color\ColorResource;
use App\Models\Color;
use App\Models\ProductDetail;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    protected $color;
    public function __construct(Color $color)
    {
        $this->color = $color;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colors = $this->color->paginate(5);
        $colorsResource = ColorResource::collection($colors)->response()->getData(true);
        return response()->json([
            'data' => $colorsResource,
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreColorRequest $request)
    {
        $color = $request->input('color');
        $check = Color::where('color', $color)->exists();
        if ($check) {
            return response()->json([
                'error' => 'Màu này đã tồn tại.'
            ], HttpResponse::HTTP_CONFLICT);
        }
        $dataCreate = $request->all();
        $color = $this->color->create($dataCreate);
        $colorResource = new ColorResource($color);
        return response()->json([
            'data' => $colorResource,
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
    public function update(UpdateColorRequest $request, string $id)
    {
        $color = $this->color->findOrFail($id);
        $dataUpdate = $request->all();
        $check = Color::where('color', $dataUpdate['color'])->exists();
        if ($check) {
            return response()->json([
                'error' => 'Màu này đã tồn tại!',
            ], HttpResponse::HTTP_CONFLICT);
        }
        $color->update($dataUpdate);
        $colorResource = new ColorResource($color);
        return response()->json([
            'data' => $colorResource,
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $isUsedInOtherTable = ProductDetail::where('color_id', $id)->exists();
        if ($isUsedInOtherTable) {
            return response()->json([
                'error' => 'Màu này đang có sản phẩm nên không thể xóa.',
            ], HttpResponse::HTTP_CONFLICT);
        }
        $color = $this->color->where('color_id', $id)->firstOrFail();
        $color->delete();
        $colorResource = new ColorResource($color);
        return response()->json([
            'data' => $colorResource,
        ], HttpResponse::HTTP_OK);
    }
}
