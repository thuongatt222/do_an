<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderDetail\StoreOrderDetailRequest;
use App\Http\Requests\OrderDetail\UpdateOrderDetailRequest;
use App\Http\Resources\OrderDetail\OrderDetailResource;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    protected $order_detail;
    public function __construct(OrderDetail $order_detail)
    {
        $this->order_detail = $order_detail;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order_details = $this->order_detail->paginate(5);
        $order_detailsResource = OrderDetailResource::collection($order_details)->response()->getData(true);
        return response()->json([
            'data' => $order_detailsResource,
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderDetailRequest $request)
    {
        $dataCreate = $request->all();
        $order_detail = $this->order_detail->create($dataCreate);
        $order_detailResource = new OrderDetailResource($order_detail);
        return response()->json([
            'data' => $order_detailResource,
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
    public function update(UpdateOrderDetailRequest $request, string $id)
    {
        $order_detail = $this->order_detail->findOrFail($id);
        $dataUpdate = $request->all();
        $order_detail->update($dataUpdate);
        $order_detailResource = new OrderDetailResource($order_detail);
        return response()->json([
            'data' => $order_detailResource,
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order_detail = $this->order_detail->where('order_detail_id', $id)->firstOrFail();
        $order_detail->delete();
        $order_detailResource = new OrderDetailResource($order_detail);
        return response()->json([
            'data' => $order_detailResource,
        ], HttpResponse::HTTP_OK);
    }
    /**
     * Add a product to the cart.
     */
    public function cart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity'); // Default quantity is 1 if not specified

        // Assuming you have a Product model to find the product details
        $product = Product::findOrFail($productId);

        // Check if the cart is already in the session
        $cart = session()->get('cart', []);

        // Check if this product exists in the cart
        if (isset($cart[$productId])) {
            // Product exists in the cart, update the quantity
            $cart[$productId]['quantity'] += $quantity;
        } else {
            // Product does not exist in the cart, add to the cart with product details
            $cart[$productId] = [
                "name" => $product->name,
                "price" => $product->price,
                "quantity" => $quantity,
            ];
        }

        // Put the cart back into the session
        session()->put('cart', $cart);

        return response()->json([
            'data' => session()->get('cart'),
        ], HttpResponse::HTTP_OK);
    }
    /**
     * Remove a product from the cart.
     */
    public function removeFromCart(Request $request)
    {
        $productId = $request->input('product_id');

        // Retrieve the cart from the session
        $cart = session()->get('cart', []);

        // Check if the product exists in the cart
        if (isset($cart[$productId])) {
            // Product exists, remove it from the cart
            unset($cart[$productId]);

            // Update the session with the new cart
            session()->put('cart', $cart);

            return response()->json([
                'message' => 'Product removed successfully from the cart',
                'data' => session()->get('cart'),
            ], HttpResponse::HTTP_OK);
        } else {
            // Product not found in the cart, return an error message
            return response()->json([
                'message' => 'Product not found in the cart',
            ], HttpResponse::HTTP_NOT_FOUND);
        }
    }
    /**
     * Display the shopping cart.
     */
    public function showCart()
    {
        // Retrieve the cart from the session, default to an empty array if not found
        $cart = session()->get('cart', []);

        // Calculate total price for the cart items
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        // Return the cart data along with the total price
        return response()->json([
            'data' => $cart,
            'total_price' => $totalPrice,
            'message' => 'Cart retrieved successfully',
        ], HttpResponse::HTTP_OK);
    }
}
