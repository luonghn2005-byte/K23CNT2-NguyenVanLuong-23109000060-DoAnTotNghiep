@extends('layouts.app')

@section('content')
<style>
    /* --- HIỆU ỨNG NỀN ĐỘNG GRADIENT --- */
    body {
        /* Tạo nền gradient động */
        background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
        background-size: 400% 400%;
        animation: gradientBG 15s ease infinite;
        min-height: 100vh;
    }

    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Lớp phủ mờ (Overlay) để làm dịu màu nền, giúp nội dung dễ đọc */
    body::before {
        content: "";
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(255, 255, 255, 0.7); /* Phủ lớp trắng mờ 70% */
        backdrop-filter: blur(5px); /* Làm mờ nền phía sau */
        z-index: -1;
    }

    /* Đảm bảo các thẻ card nổi bật trên nền */
    .card {
        background-color: rgba(255, 255, 255, 0.95) !important;
        border-radius: 15px !important;
        border: none !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
        backdrop-filter: blur(10px);
    }
    .card-header {
        background-color: transparent !important;
        border-bottom: 1px solid rgba(0,0,0,0.05) !important;
    }
    
    /* Chỉnh màu chữ cho nổi bật */
    .text-dark { color: #1a1a1a !important; }
    .text-muted { color: #6c757d !important; }
    
    .table { color: #333 !important; }
    .table-light th {
        background-color: #f8f9fa !important;
        color: #555 !important;
        font-weight: 600 !important;
    }
</style>

<!-- Lời chào -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1 text-dark">👋 Chào ngày mới, {{ auth()->user()->name }}!</h3>
        <p class="text-muted mb-0 fw-bold">Dưới đây là tình hình hoạt động của chuỗi quán hôm nay.</p>
    </div>
    <div class="text-end">
        <span class="badge bg-white text-dark border px-3 py-2 shadow-sm rounded-pill">
            <i class="bi bi-calendar3 text-primary"></i> {{ date('d/m/Y') }}
        </span>
    </div>
</div>

<!-- 4 Thẻ thống kê -->
<div class="row g-4 mb-4">
    <!-- Doanh thu -->
    <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm" style="background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%); color: white;">
            <div class="card-body position-relative overflow-hidden">
                <h6 class="text-uppercase mb-2 opacity-75" style="font-size: 0.8rem; letter-spacing: 1px; color: #fff !important;">Doanh thu</h6>
                <h3 class="fw-bold mb-0" style="color: #fff !important;">{{ number_format($totalRevenue) }} đ</h3>
                <i class="bi bi-wallet2 position-absolute end-0 bottom-0 opacity-25" style="font-size: 5rem; transform: translate(10px, 15px); color: #fff;"></i>
            </div>
        </div>
    </div>
    <!-- Đơn hàng -->
    <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white;">
            <div class="card-body position-relative overflow-hidden">
                <h6 class="text-uppercase mb-2 opacity-75" style="font-size: 0.8rem; letter-spacing: 1px; color: #fff !important;">Đơn hàng</h6>
                <h3 class="fw-bold mb-0" style="color: #fff !important;">{{ $totalOrders }}</h3>
                <i class="bi bi-receipt position-absolute end-0 bottom-0 opacity-25" style="font-size: 5rem; transform: translate(10px, 15px); color: #fff;"></i>
            </div>
        </div>
    </div>
    <!-- Sản phẩm -->
    <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm" style="background: linear-gradient(135deg, #00c6ff 0%, #0072ff 100%); color: white;">
            <div class="card-body position-relative overflow-hidden">
                <h6 class="text-uppercase mb-2 opacity-75" style="font-size: 0.8rem; letter-spacing: 1px; color: #fff !important;">Sản phẩm</h6>
                <h3 class="fw-bold mb-0" style="color: #fff !important;">{{ $totalProducts }}</h3>
                <i class="bi bi-cup-hot position-absolute end-0 bottom-0 opacity-25" style="font-size: 5rem; transform: translate(10px, 15px); color: #fff;"></i>
            </div>
        </div>
    </div>
    <!-- Chi nhánh -->
    <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm" style="background: linear-gradient(135deg, #f12711 0%, #f5af19 100%); color: white;">
            <div class="card-body position-relative overflow-hidden">
                <h6 class="text-uppercase mb-2 opacity-75" style="font-size: 0.8rem; letter-spacing: 1px; color: #fff !important;">Chi nhánh</h6>
                <h3 class="fw-bold mb-0" style="color: #fff !important;">{{ $totalBranches }}</h3>
                <i class="bi bi-shop position-absolute end-0 bottom-0 opacity-25" style="font-size: 5rem; transform: translate(10px, 15px); color: #fff;"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Biểu đồ doanh thu -->
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-graph-up-arrow text-primary me-2"></i> Biểu đồ doanh thu 7 ngày</h6>
                <button class="btn btn-sm btn-light border text-muted">Tuần này</button>
            </div>
            <div class="card-body pt-0">
                <canvas id="revenueChart" height="110"></canvas>
            </div>
        </div>
    </div>

    <!-- Top sản phẩm bán chạy -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header py-3">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-fire text-danger me-2"></i> Top sản phẩm bán chạy</h6>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($topProducts as $index => $item)
                        <div class="list-group-item d-flex align-items-center py-3 border-0 border-bottom bg-transparent">
                            <div class="me-3 fw-bold fs-5 text-muted" style="width: 25px;">#{{ $index + 1 }}</div>
                            <img src="{{ $item->product->image ?? 'https://via.placeholder.com/50' }}" class="rounded me-3 object-fit-cover" width="45" height="45" alt="">
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-bold text-dark">{{ $item->product->name ?? 'Sản phẩm đã xóa' }}</h6>
                                <small class="text-muted">{{ number_format($item->product->price ?? 0) }} đ</small>
                            </div>
                            <span class="badge bg-primary rounded-pill">{{ $item->total_qty }} ly</span>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">Chưa có dữ liệu bán hàng</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Đơn hàng mới nhất -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-clock-history text-warning me-2"></i> Đơn hàng mới nhất</h6>
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-link text-decoration-none">Xem tất cả</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-muted small text-uppercase">
                            <tr>
                                <th class="ps-4">Mã đơn</th>
                                <th>Khách hàng / Nhân viên</th>
                                <th>Thời gian</th>
                                <th>Trạng thái</th>
                                <th class="text-end pe-4">Tổng tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                                <tr>
                                    <td class="ps-4 fw-bold text-primary">{{ $order->code }}</td>
                                    <td>
                                        @if($order->customer_name)
                                            <span class="fw-bold text-dark">{{ $order->customer_name }}</span> <br>
                                            <small class="text-muted">{{ $order->customer_phone }}</small>
                                        @else
                                            <span class="text-muted">Khách tại quầy</span>
                                        @endif
                                    </td>
                                    <td class="text-muted">{{ $order->created_at->format('H:i - d/m/Y') }}</td>
                                    <td>
                                        @if($order->status == 'paid')
                                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Đã thanh toán</span>
                                        @elseif($order->status == 'pending')
                                            <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill">Chờ xử lý</span>
                                        @else
                                            <span class="badge bg-secondary px-3 py-2 rounded-pill">Đã hủy</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4 fw-bold text-danger">{{ number_format($order->total) }} đ</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Chưa có đơn hàng nào</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    
    let gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(75, 108, 183, 0.8)');   
    gradient.addColorStop(1, 'rgba(75, 108, 183, 0.1)');  

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: {!! json_encode($chartValues) !!},
                backgroundColor: gradient,
                borderRadius: 8,
                borderSkipped: false,
                barPercentage: 0.5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1a1a1a',
                    padding: 12,
                    titleFont: { size: 14 },
                    bodyFont: { size: 14, weight: 'bold' },
                    callbacks: {
                        label: function(context) {
                            return new Intl.NumberFormat('vi-VN').format(context.raw) + ' đ';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { borderDash: [5, 5], color: '#e0e0e0' },
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('vi-VN', { notation: "compact" }).format(value);
                        },
                        color: '#888'
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#888' }
                }
            }
        }
    });
</script>
@endpush