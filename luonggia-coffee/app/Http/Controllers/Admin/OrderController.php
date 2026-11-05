<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller {
    public function index(Request $request) {
        $query = Order::with('items.product')->latest();

        // Lọc theo trạng thái
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order) {
        $order->load(['items.product', 'user']);
        return view('admin.orders.show', compact('order'));
    }

    // Cập nhật trạng thái đơn hàng
    public function updateStatus(Request $r, Order $order) {
        $r->validate(['status' => 'required|in:paid,cancelled']);
        $order->update(['status' => $r->status]);
        return back()->with('ok', 'Cập nhật trạng thái đơn hàng thành công!');
    }
}