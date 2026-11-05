@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0 text-dark">🧾 Quản lý Đơn hàng</h4>
</div>

<div class="card">
    <div class="card-body p-4">
        
        <!-- Bộ lọc trạng thái -->
        <form action="{{ route('admin.orders.index') }}" method="GET" class="mb-4 d-flex gap-2">
            <select name="status" class="form-select w-auto" onchange="this.form.submit()">
                <option value="">-- Tất cả trạng thái --</option>
                <option value="pending" @selected(request('status') == 'pending')>Chờ xử lý</option>
                <option value="paid" @selected(request('status') == 'paid')>Đã thanh toán</option>
                <option value="cancelled" @selected(request('status') == 'cancelled')>Đã hủy</option>
            </select>
            @if(request('status'))
                <a href="{{ route('admin.orders.index') }}" class="btn btn-light border">Hủy lọc</a>
            @endif
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle border">
                <thead class="table-light">
                    <tr>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Thanh toán</th>
                        <th>Trạng thái</th>
                        <th class="text-end pe-4">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $o)
                    <tr>
                        <td class="fw-bold text-primary">{{ $o->code }}</td>
                        <td>
                            @if($o->customer_name)
                                <span class="fw-bold text-dark">{{ $o->customer_name }}</span> <br>
                                <small class="text-muted">{{ $o->customer_phone }}</small>
                            @else
                                <span class="text-muted">Khách tại quầy</span>
                            @endif
                        </td>
                        <td class="text-muted">{{ $o->created_at->format('H:i - d/m/Y') }}</td>
                        <td class="fw-bold text-danger">{{ number_format($o->total) }} đ</td>
                        <td>
                            @if($o->payment_method == 'transfer')
                                <span class="badge bg-info text-dark"><i class="bi bi-bank"></i> Chuyển khoản</span>
                            @else
                                <span class="badge bg-secondary"><i class="bi bi-cash"></i> Tiền mặt</span>
                            @endif
                        </td>
                        <td>
                            @if($o->status == 'paid')
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Đã thanh toán</span>
                            @elseif($o->status == 'pending')
                                <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill">Chờ xử lý</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">Đã hủy</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.orders.show', $o) }}" class="btn btn-sm btn-outline-primary fw-bold">
                                <i class="bi bi-eye"></i> Xem chi tiết
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Không có đơn hàng nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $orders->links() }}</div>
    </div>
</div>
@endsection