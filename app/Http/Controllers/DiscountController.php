<?php

namespace App\Http\Controllers;

use App\Http\Requests\Discount\StoreDiscountRequest;
use App\Http\Requests\Discount\UpdateDiscountRequest;
use App\Http\Resources\Discount\DiscountResource;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

class DiscountController extends Controller
{
    protected $discount;
    public function __construct(Discount $discount)
    {
        $this->discount = $discount;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discount = $this->discount->paginate(5);
        $discountResource = DiscountResource::collection($discount)->response()->getData(true);
        return response()->json([
            'data' => $discountResource,
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDiscountRequest $request)
    {
        $dataCreate = $request->all();
        $discount = $this->discount->create($dataCreate);
        $discountResource = new DiscountResource($discount);
        return response()->json([
            'data' => $discountResource,
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
    public function update(UpdateDiscountRequest $request, string $id)
    {
        $discount = $this->discount->findOrFail($id);
        $dataUpdate = $request->all();
        $discount->update($dataUpdate);
        $discountResource = new DiscountResource($discount);
        return response()->json([
            'data' => $discountResource,
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $discount = $this->discount->where('discount_id', $id)->firstOrFail();
        $discount->delete();
        $discountResource = new DiscountResource($discount);
        return response()->json([
            'data' => $discountResource,
        ], HttpResponse::HTTP_OK);
    }
}
