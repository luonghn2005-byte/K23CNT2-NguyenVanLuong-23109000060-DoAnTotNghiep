@extends('layouts.app')
@section('content')
<div class="mb-4">
    <a href="{{ route('admin.customers.index') }}" class="btn btn-light border shadow-sm mb-3"><i class="bi bi-arrow-left"></i> Quay lại danh sách</a>
    <h4 class="fw-bold text-dark">Hồ sơ Khách hàng: {{ $customer->name }}</h4>
</div>

<div class="row g-4">
    <!-- Thông tin cá nhân -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-person-badge"></i> Thông tin cá nhân</h6>
            </div>
            <div class="card-body p-4 text-center">
                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 100px; height: 100px;">
                    <i class="bi bi-person text-secondary" style="font-size: 3rem;"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">{{ $customer->name }}</h5>
                <p class="text-muted mb-3">{{ $customer->email }}</p>
                
                <div class="text-start border-top pt-3">
                    <p class="mb-2"><strong>Ngày tham gia:</strong> {{ $customer->created_at->format('d/m/Y') }}</p>
                    <p class="mb-2"><strong>Tổng chi tiêu:</strong> <span class="fw-bold text-danger">{{ number_format($totalSpent) }} đ</span></p>
                    <p class="mb-0"><strong>Tổng đơn hàng:</strong> {{ $orders->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Lịch sử đơn hàng -->
    <div class="col-md-8">
        <div class="card h-100">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="fw-bold mb-0 text-warning"><i class="bi bi-clock-history"></i> Lịch sử mua hàng</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Mã đơn</th>
                                <th>Ngày đặt</th>
                                <th>Trạng thái</th>
                                <th class="text-end pe-4">Tổng tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td class="ps-4 fw-bold text-primary">{{ $order->code }}</td>
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
                                <td colspan="4" class="text-center py-4 text-muted">Khách hàng chưa có đơn hàng nào</td>
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