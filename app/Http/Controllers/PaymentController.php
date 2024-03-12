<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payment\StorePaymentRequest;
use App\Http\Requests\Payment\UpdatePaymentRequest;
use App\Http\Resources\Payment\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    protected $payment;
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = $this->payment->paginate(5);
        $paymentsResource = PaymentResource::collection($payments)->response()->getData(true);
        return response()->json([
            'data' => $paymentsResource,
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        $dataCreate = $request->all();
        $check = Payment::where('payment_method', $dataCreate['payment_method'])->exists();
        if ($check) {
            return response()->json([
                'error' => 'Phương thức đã tồn tại!'
            ], HttpResponse::HTTP_CONFLICT);
        }
        $payment = $this->payment->create($dataCreate);
        $paymentResource = new PaymentResource($payment);
        return response()->json([
            'data' => $paymentResource,
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
    public function update(UpdatePaymentRequest $request, string $id)
    {
        $payment = $this->payment->findOrFail($id);
        $dataUpdate = $request->all();
        $check = Payment::where('payment_method', $dataUpdate['payment_method'])->exists();
        if ($check) {
            return response()->json([
                'error' => 'Phương thức đã tồn tại!'
            ], HttpResponse::HTTP_CONFLICT);
        }
        $payment->update($dataUpdate);
        $paymentResource = new PaymentResource($payment);
        return response()->json([
            'data' => $paymentResource,
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $isUsedInOtherTable = Payment::where('payment_method_id', $id)->exists();
        if ($isUsedInOtherTable) {
            return response()->json([
                'error' => 'Phương thức này đã tồn tại trong hóa đơn nên không thể xóa.',
            ], HttpResponse::HTTP_CONFLICT);
        }
        $payment = $this->payment->where('payment_method_id', $id)->firstOrFail();
        $payment->delete();
        $paymentResource = new PaymentResource($payment);
        return response()->json([
            'data' => $paymentResource,
        ], HttpResponse::HTTP_OK);
    }
}
