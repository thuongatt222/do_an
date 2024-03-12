<?php

namespace App\Http\Controllers;

use App\Http\Requests\Voucher\StoreVoucherRequest;
use App\Http\Requests\Voucher\UpdateVoucherRequest;
use App\Http\Resources\Voucher\VoucherResource;
use App\Models\Order;
use App\Models\Voucher;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    protected $voucher;
    public function __construct(Voucher $voucher)
    {
        $this->voucher = $voucher;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $voucher = $this->voucher->paginate(5);
        $vouchersResource = VoucherResource::collection($voucher)->response()->getData(true);
        return response()->json([
            'data' => $vouchersResource,
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVoucherRequest $request)
    {
        $voucher = $request->input('voucher');
        $check = Voucher::where('voucher', $voucher)->exists();
        if ($check) {
            return response()->json([
                'error' => 'Voucher này đã tồn tại!'
            ], HttpResponse::HTTP_CONFLICT);
        }
        $dataCreate = $request->all();
        $voucher = $this->voucher->create($dataCreate);
        $voucherResource = new VoucherResource($voucher);
        return response()->json([
            'data' => $voucherResource,
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
    public function update(UpdateVoucherRequest $request, string $id)
    {
        $voucher = $this->voucher->findOrFail($id);
        $dataUpdate = $request->all();
        $check = Voucher::where('voucher', $dataUpdate['voucher'])->exists();
        if ($check) {
            return response()->json([
                'error' => 'Voucher này đã tồn tại!',
            ], HttpResponse::HTTP_CONFLICT);
        }
        $voucher->update($dataUpdate);
        $voucherResource = new VoucherResource($voucher);
        return response()->json([
            'data' => $voucherResource,
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $isUsedInOtherTable = Order::where('voucher_id', $id)->exists();
        if ($isUsedInOtherTable) {
            return response()->json([
                'error' => 'Voucher này đang có sản phẩm nên không thể xóa.',
            ], HttpResponse::HTTP_CONFLICT);
        }
        $voucher = $this->voucher->where('voucher_id', $id)->firstOrFail();
        $voucher->delete();
        $voucherResource = new VoucherResource($voucher);
        return response()->json([
            'data' => $voucherResource,
        ], HttpResponse::HTTP_OK);
    }
}
