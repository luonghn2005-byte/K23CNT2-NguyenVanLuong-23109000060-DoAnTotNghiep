<?php
namespace App\Http\Controllers;
use App\Models\{Product, Order, OrderItem, Category, Voucher};
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClientController extends Controller {
    // Trang chủ hiển thị thực đơn
    public function index() {
        $categories = Category::with(['products' => function($q) {
            $q->where('is_active', true);
        }])->get();
        
        return view('client.home', compact('categories'));
    }

    // Hàm kiểm tra mã giảm giá
    public function checkVoucher(Request $r) {
        $voucher = Voucher::where('code', strtoupper($r->code))->first();

        if (!$voucher) {
            return response()->json(['ok' => false, 'msg' => 'Mã giảm giá không tồn tại!']);
        }
        if (!$voucher->is_active || $voucher->expires_at < now()) {
            return response()->json(['ok' => false, 'msg' => 'Mã giảm giá đã hết hạn!']);
        }
        if ($voucher->used_count >= $voucher->max_uses) {
            return response()->json(['ok' => false, 'msg' => 'Mã giảm giá đã hết lượt sử dụng!']);
        }

        return response()->json([
            'ok' => true, 
            'discount_percent' => $voucher->discount_percent,
            'msg' => 'Áp dụng thành công! Giảm ' . $voucher->discount_percent . '%'
        ]);
    }

    // Xử lý đặt hàng
    public function checkout(Request $r) {
        $r->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        $discountAmount = 0;
        $voucher = null;

        // Xử lý Voucher
        if ($r->voucher_code) {
            $voucher = Voucher::where('code', strtoupper($r->voucher_code))->first();
            if ($voucher && $voucher->is_active && $voucher->expires_at >= now() && $voucher->used_count < $voucher->max_uses) {
                $voucher->increment('used_count'); // Tăng lượt sử dụng
            } else {
                $voucher = null; // Mã không hợp lệ
            }
        }

        // Tạo đơn hàng
        $order = Order::create([
            'branch_id' => null,
            'user_id' => auth()->id() ?? null,
            'customer_name' => $r->name,
            'customer_phone' => $r->phone,
            'customer_address' => $r->address,
            'code' => 'OL' . now()->format('YmdHis') . Str::upper(Str::random(3)),
            'status' => 'pending',
            'total' => 0,
            'voucher_code' => $voucher ? $voucher->code : null,
        ]);

        $total = 0;
        foreach ($r->items as $it) {
            $p = Product::find($it['id']);
            $sub = $p->price * $it['qty'];
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $p->id,
                'quantity' => $it['qty'],
                'unit_price' => $p->price,
                'subtotal' => $sub,
            ]);
            $total += $sub;
        }

        // Tính toán giảm giá
        if ($voucher) {
            $discountAmount = ($total * $voucher->discount_percent) / 100;
        }
        
        $finalTotal = $total - $discountAmount;
        $order->update(['total' => $finalTotal, 'discount_amount' => $discountAmount]);

        return response()->json(['ok' => true, 'order_code' => $order->code, 'total' => $finalTotal]);
    }
}