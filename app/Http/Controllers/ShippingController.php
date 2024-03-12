<?php

namespace App\Http\Controllers;

use App\Http\Requests\Shipping\StoreShippingRequest;
use App\Http\Requests\Shipping\UpdateShippingRequest;
use App\Http\Resources\Shipping\ShippingResource;
use App\Models\Order;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

class ShippingController extends Controller
{
    protected $shipping;
    public function __construct(Shipping $shipping)
    {
        $this->shipping = $shipping;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shippings = $this->shipping->paginate(5);
        $shippingsResource = ShippingResource::collection($shippings)->response()->getData(true);
        return response()->json([
            'data' => $shippingsResource,
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShippingRequest $request)
    {
        $dataCreate = $request->all();
        $check = Shipping::where('shipping_method', $dataCreate['shipping_method'])->exists();
        if($check){
            return response()->json([
                'error' => 'Phương thức đã tồn tại!'
            ], HttpResponse::HTTP_CONFLICT);
        }
        $shipping = $this->shipping->create($dataCreate);
        $shippingResource = new ShippingResource($shipping);
        return response()->json([
            'data' => $shippingResource,
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
    public function update(UpdateShippingRequest $request, string $id)
    {
        $shipping = $this->shipping->findOrFail($id);
        $dataUpdate = $request->all();
        $check = Shipping::where('shipping_method', $dataUpdate['shipping_method'])->exists();
        if($check){
            return response()->json([
                'error' => 'Phương thức đã tồn tại!'
            ], HttpResponse::HTTP_CONFLICT);
        }
        $shipping->update($dataUpdate);
        $shippingResource = new ShippingResource($shipping);
        return response()->json([
            'data' => $shippingResource,
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $isUsedInOtherTable = Order::where('shipping_method_id', $id)->exists();
        if ($isUsedInOtherTable) {
            return response()->json([
                'error' => 'Phương thức này đã tồn tại trong hóa đơn nên không thể xóa.',
            ], HttpResponse::HTTP_CONFLICT);
        }
        $shipping = $this->shipping->where('shipping_method_id', $id)->firstOrFail();
        $shipping->delete();
        $shippingResource = new ShippingResource($shipping);
        return response()->json([
            'data' => $shippingResource,
        ], HttpResponse::HTTP_OK);
    }
}
