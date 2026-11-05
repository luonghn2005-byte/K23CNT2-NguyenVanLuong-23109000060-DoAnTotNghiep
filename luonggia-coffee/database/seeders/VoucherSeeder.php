<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller {
    public function index() {
        $vouchers = Voucher::orderBy('id', 'desc')->paginate(10);
        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function store(Request $r) {
        $data = $r->validate([
            'code' => 'required|string|unique:vouchers,code|max:20',
            'discount_percent' => 'required|integer|min:1|max:100',
            'max_uses' => 'required|integer|min:1',
            'expires_at' => 'required|date',
        ]);
        $data['code'] = strtoupper($data['code']);
        $data['is_active'] = true;
        Voucher::create($data);
        return back()->with('ok', 'Tạo mã giảm giá thành công!');
    }

    // Hàm xử lý cập nhật Voucher
    public function update(Request $r, Voucher $voucher) {
        $data = $r->validate([
            'code' => 'required|string|max:20|unique:vouchers,code,' . $voucher->id,
            'discount_percent' => 'required|integer|min:1|max:100',
            'max_uses' => 'required|integer|min:1',
            'expires_at' => 'required|date',
        ]);
        
        $data['code'] = strtoupper($data['code']);
        $data['is_active'] = $r->has('is_active') ? true : false;
        
        $voucher->update($data);
        return back()->with('ok', 'Cập nhật mã giảm giá thành công!');
    }

    public function destroy(Voucher $voucher) {
        $voucher->delete();
        return back()->with('ok', 'Đã xóa mã giảm giá!');
    }
}