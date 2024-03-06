<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    
    public function store(Request $request)
    {
        $check =  DB::table('brand')->get();
        foreach ($check as $value) {
            if ($value->size == $request->input('brand_name')) {
                flash()->addError('Kích cỡ này đã tồn tại.');
            }
        }
        $result = DB::table('brand')->insert([
            'brand_name'=>$request->input('brand_name'),
            'created_at' => now(),
        ]);
        if($result){
            flash()->addSuccess('Thêm thành công');
            return redirect()->route('brand');
        }else{
            flash()->addError("Thêm thất bại");
            return redirect()->route('brand');
        }
    }
    public function update(Request $request){
        $result = DB::table('brand')
        ->where('brand_id', $request->input('brand_id'))
        ->update([
            'brand_name'=>$request->input('brand_name'),
            'updated_at' => now(),
        ]);
        if($result){
            flash()->addSuccess('Thêm thành công');
            return redirect()->route('brand');
        }else{
            flash()->addError("Thêm thất bại");
            return redirect()->route('brand');
        }
    }
    public function destroy(Request $request){
        $hasRelatedRecords = DB::table('brand')->where('brand_id', $request->input('id'))->exists();
        if ($hasRelatedRecords) {
            flash()->addError("Xóa thất bại - Có dữ liệu liên quan");
            return redirect()->back();
        }
        $result = DB::table('brand')->where('brand_id', '=', $request->input('id'))->delete();
        if($result){
            flash()->addSuccess('Xóa thành công');
            return redirect()->route('brand');
        }else{
            flash()->addError("Xóa thất bại");
            return redirect()->route('brand');
        }
    }
}
