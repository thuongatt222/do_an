<?php

namespace App\Http\Controllers;

use App\Models\size as ModelsSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class size extends Controller
{
    public $data = [];

    private $size;
    public function __construct()
    {
        $this->size = new size(); // Corrected the instantiation
    }

    public function index()
    {
        $this->data['size'] = ModelsSize::get()
        ->paginate(5); 
        return view('size.index', $this->data);
    }
    public function store(Request $request)
    {
        $check =  DB::table('size')->get();
        foreach ($check as $value) {
            if ($value->size == $request->input('size')) {
                flash()->addError('Kích cỡ này đã tồn tại.');
            }
        }
        $result = DB::table('size')->insert([
            'size'=>$request->input('size'),
            'created_at' => now(),
        ]);
        if($result){
            flash()->addSuccess('Thêm thành công');
            return redirect()->route('size');
        }else{
            flash()->addError("Thêm thất bại");
            return redirect()->route('size');
        }
    }
    public function update(Request $request){
        $check =  DB::table('size')->get();
        foreach ($check as $value) {
            if ($value->size == $request->input('size')) {
                flash()->addError('Kích cỡ này đã tồn tại.');
            }
        }
        $result = DB::table('size')
        ->where('size_id', $request->input('id'))
        ->update([
            'size'=>$request->input('size'),
            'updated_at' => now(),
        ]);
        if($result){
            flash()->addSuccess('Thêm thành công');
            return redirect()->route('size');
        }else{
            flash()->addError("Thêm thất bại");
            return redirect()->route('size');
        }
    }
    public function destroy(Request $request){
        $hasRelatedRecords = DB::table('size')->where('size_id', $request->input('id'))->exists();
        if ($hasRelatedRecords) {
            flash()->addError("Xóa thất bại - Có dữ liệu liên quan");
            return redirect()->back();
        }
        $result = DB::table('size')->where('size_id', '=', $request->input('id'))->delete();
        if($result){
            flash()->addSuccess('Xóa thành công');
            return redirect()->route('size');
        }else{
            flash()->addError("Xóa thất bại");
            return redirect()->route('size');
        }
    }
}
