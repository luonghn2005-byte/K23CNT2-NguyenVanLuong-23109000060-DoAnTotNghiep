<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Order, Product, Branch, User, OrderItem};
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {
    public function index() {
        // 1. Thống kê tổng quan
        $totalOrders   = Order::count();
        $totalRevenue  = Order::where('status','paid')->sum('total');
        $totalProducts = Product::count();
        $totalBranches = Branch::count();
        
        // 2. Lấy danh sách 5 đơn hàng mới nhất
        $recentOrders = Order::latest()->take(5)->get();

        // 3. Tính doanh thu 7 ngày gần nhất (để vẽ biểu đồ)
        $chartData = Order::where('status', 'paid')
            ->where('created_at', '>=', now()->subDays(7))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as revenue')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartLabels = [];
        $chartValues = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = now()->subDays($i)->format('d/m');
            
            $found = $chartData->firstWhere('date', $date);
            $chartValues[] = $found ? (int)$found->revenue : 0;
        }

        // 4. Lấy Top 5 sản phẩm bán chạy nhất
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_qty'))
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders', 'totalRevenue', 'totalProducts', 'totalBranches', 
            'recentOrders', 'chartLabels', 'chartValues', 'topProducts'
        ));
    }
}