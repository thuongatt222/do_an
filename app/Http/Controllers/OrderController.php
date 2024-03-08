<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $order;
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = $this->order->paginate(5);
        $orderResource = OrderResource::collection($order)->response()->getData(true);
        return response()->json([
            'data' => $orderResource,
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $dataCreate = $request->all();
        $order = $this->order->create($dataCreate);
        $orderResource = new OrderResource($order);
        return response()->json([
            'data' => $orderResource,
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
    public function update(UpdateOrderRequest $request, string $id)
    {
        $order = $this->order->findOrFail($id);
        $dataUpdate = $request->all();
        $order->update($dataUpdate);
        $orderResource = new OrderResource($order);
        return response()->json([
            'data' => $orderResource,
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = $this->order->where('order_id', $id)->firstOrFail();
        $order->delete();
        $orderResource = new OrderResource($order);
        return response()->json([
            'data' => $orderResource,
        ], HttpResponse::HTTP_OK);
    }
}
