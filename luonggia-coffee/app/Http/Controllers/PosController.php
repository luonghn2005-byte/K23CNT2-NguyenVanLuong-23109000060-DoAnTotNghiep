<?php
namespace App\Http\Controllers;
use App\Models\{Product, Order, OrderItem, Voucher};
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PosController extends Controller {
    public function index() {
        $products = Product::with('category')->where('is_active', true)->get();
        return view('pos.index', compact('products'));
    }

    // Hàm kiểm tra mã giảm giá cho POS
    public function checkVoucher(Request $r) {
        $voucher = Voucher::where('code', strtoupper($r->code))->first();

        if (!$voucher) {
            return response()->json(['ok' => false, 'msg' => 'Mã không tồn tại!']);
        }
        if (!$voucher->is_active || $voucher->expires_at < now()) {
            return response()->json(['ok' => false, 'msg' => 'Mã đã hết hạn!']);
        }
        if ($voucher->used_count >= $voucher->max_uses) {
            return response()->json(['ok' => false, 'msg' => 'Mã đã hết lượt!']);
        }

        return response()->json([
            'ok' => true, 
            'discount_percent' => $voucher->discount_percent,
            'msg' => 'Giảm ' . $voucher->discount_percent . '%'
        ]);
    }

    public function checkout(Request $r) {
        $r->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,transfer'
        ]);

        $discountAmount = 0;
        $voucher = null;

        if ($r->voucher_code) {
            $voucher = Voucher::where('code', strtoupper($r->voucher_code))->first();
            if ($voucher && $voucher->is_active && $voucher->expires_at >= now() && $voucher->used_count < $voucher->max_uses) {
                $voucher->increment('used_count');
            } else {
                $voucher = null;
            }
        }

        $order = Order::create([
            'branch_id' => auth()->user()->branch_id ?? 1,
            'user_id' => auth()->id(),
            'code' => 'LG' . now()->format('YmdHis') . Str::upper(Str::random(3)),
            'status' => 'paid',
            'payment_method' => $r->payment_method,
            'total' => 0,
            'voucher_code' => $voucher ? $voucher->code : null,
        ]);

        $total = 0;
        foreach ($r->items as $it) {
            $p = Product::find($it['id']);
            $sub = $p->price * $it['qty'];
            OrderItem::create([
                'order_id' => $order->id, 'product_id' => $p->id,
                'quantity' => $it['qty'], 'unit_price' => $p->price, 'subtotal' => $sub,
            ]);
            $total += $sub;
        }

        if ($voucher) {
            $discountAmount = ($total * $voucher->discount_percent) / 100;
        }
        
        $finalTotal = $total - $discountAmount;
        $order->update(['total' => $finalTotal, 'discount_amount' => $discountAmount]);

        return response()->json(['ok' => true, 'order_code' => $order->code, 'total' => $finalTotal]);
    }
}   