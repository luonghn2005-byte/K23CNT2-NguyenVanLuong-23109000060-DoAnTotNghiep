@extends('layouts.app')
@section('content')
<div class="mb-4">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-light border shadow-sm mb-3"><i class="bi bi-arrow-left"></i> Quay lại</a>
    <h4 class="fw-bold text-dark">Chi tiết đơn hàng #{{ $order->code }}</h4>
</div>

<div class="row g-4">
    <!-- Thông tin giao hàng -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-geo-alt"></i> Thông tin nhận hàng</h6>
            </div>
            <div class="card-body">
                <p class="mb-2"><strong>Người nhận:</strong> {{ $order->customer_name ?? 'Khách tại quầy' }}</p>
                <p class="mb-2"><strong>Số điện thoại:</strong> {{ $order->customer_phone ?? '-' }}</p>
                <p class="mb-2"><strong>Địa chỉ:</strong> {{ $order->customer_address ?? '-' }}</p>
                <p class="mb-2"><strong>Phương thức TT:</strong> 
                    @if($order->payment_method == 'transfer')
                        <span class="text-info fw-bold">Chuyển khoản</span>
                    @else
                        <span class="text-secondary fw-bold">Tiền mặt</span>
                    @endif
                </p>
                <p class="mb-0"><strong>Trạng thái:</strong> 
                    @if($order->status == 'paid')
                        <span class="text-success fw-bold">Đã thanh toán</span>
                    @elseif($order->status == 'pending')
                        <span class="text-warning fw-bold">Chờ xử lý</span>
                    @else
                        <span class="text-danger fw-bold">Đã hủy</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Danh sách món & Thanh toán -->
    <div class="col-md-8">
        <div class="card h-100">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-warning"><i class="bi bi-bag-check"></i> Danh sách món</h6>
                @if($order->status == 'pending')
                <div class="d-flex gap-2">
                    <form method="post" action="{{ route('admin.orders.updateStatus', $order) }}">@csrf
                        <input type="hidden" name="status" value="cancelled">
                        <button class="btn btn-sm btn-outline-danger fw-bold" onclick="return confirm('Bạn chắc chắn muốn hủy đơn này?')"><i class="bi bi-x-circle"></i> Hủy đơn</button>
                    </form>
                    <form method="post" action="{{ route('admin.orders.updateStatus', $order) }}">@csrf
                        <input type="hidden" name="status" value="paid">
                        <button class="btn btn-sm btn-success fw-bold" onclick="return confirm('Xác nhận đơn hàng này đã được giao?')"><i class="bi bi-check-circle"></i> Xác nhận đã giao</button>
                    </form>
                </div>
                @endif
            </div>
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Sản phẩm</th>
                            <th class="text-center">SL</th>
                            <th>Đơn giá</th>
                            <th class="text-end pe-4">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $item->product->image ?? 'https://via.placeholder.com/40' }}" class="rounded me-3 object-fit-cover" width="40" height="40">
                                    <span class="fw-bold text-dark">{{ $item->product->name ?? 'SP đã xóa' }}</span>
                                </div>
                            </td>
                            <td class="text-center fw-bold">x{{ $item->quantity }}</td>
                            <td>{{ number_format($item->unit_price) }} đ</td>
                            <td class="text-end pe-4 fw-bold text-danger">{{ number_format($item->subtotal) }} đ</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white py-3">
                @if($order->voucher_code)
                <div class="d-flex justify-content-between text-success mb-1">
                    <span>Mã giảm giá ({{ $order->voucher_code }}):</span>
                    <span class="fw-bold">- {{ number_format($order->discount_amount) }} đ</span>
                </div>
                @endif
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <h5 class="mb-0 fw-bold text-dark">Tổng thanh toán:</h5>
                    <h4 class="mb-0 fw-bold text-danger">{{ number_format($order->total) }} đ</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection         