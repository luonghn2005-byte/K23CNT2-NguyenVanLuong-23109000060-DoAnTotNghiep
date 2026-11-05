<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerController extends Controller {
    public function index(Request $request) {
        // Chỉ lấy những user có role là 'customer'
        $query = User::where('role', 'customer');

        // Tìm kiếm theo tên hoặc email
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $customers = $query->orderBy('id', 'desc')->paginate(10);
        return view('admin.customers.index', compact('customers'));
    }

    // Xem chi tiết khách hàng và lịch sử mua hàng
    public function show(User $customer) {
        // Lấy danh sách đơn hàng của khách (dựa vào số điện thoại hoặc email/user_id)
        // Vì đơn online lưu customer_phone, ta có thể tìm theo SĐT hoặc user_id
        $orders = Order::where('user_id', $customer->id)
                       ->orWhere('customer_phone', $customer->phone ?? 'null')
                       ->latest()->get();
                       
        $totalSpent = $orders->where('status', 'paid')->sum('total');

        return view('admin.customers.show', compact('customer', 'orders', 'totalSpent'));
    }

    public function destroy(User $customer) {
        if ($customer->role !== 'customer') {
            return back()->withErrors(['error' => 'Không thể xóa tài khoản quản trị!']);
        }
        $customer->delete();
        return back()->with('ok', 'Đã xóa khách hàng!');
    }
}