@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0 text-dark">🎟️ Quản lý Voucher</h4>
    <button class="btn btn-primary fw-bold rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#addVoucherModal">
        <i class="bi bi-plus-lg"></i> Tạo mã mới
    </button>
</div>

<div class="card">
    <div class="card-body p-4">
        <table class="table table-hover align-middle border">
            <thead class="table-light">
                <tr>
                    <th>Mã</th>
                    <th>Giảm giá</th>
                    <th>Số lượng</th>
                    <th>Hết hạn</th>
                    <th>Trạng thái</th>
                    <th class="text-end pe-4">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vouchers as $v)
                <tr>
                    <td class="fw-bold text-primary fs-5">{{ $v->code }}</td>
                    <td><span class="badge bg-danger">{{ $v->discount_percent }}%</span></td>
                    <td>{{ $v->used_count }} / {{ $v->max_uses }}</td>
                    <td class="text-muted">{{ $v->expires_at->format('d/m/Y') }}</td>
                    <td>
                        @if($v->is_active && $v->expires_at > now() && $v->used_count < $v->max_uses)
                            <span class="badge bg-success">Đang chạy</span>
                        @else
                            <span class="badge bg-secondary">Hết hiệu lực</span>
                        @endif
                    </td>
                    <td class="text-end pe-4">
                        <!-- Nút Sửa gọi đến Modal tương ứng -->
                        <button class="btn btn-sm btn-outline-warning fw-bold me-1" data-bs-toggle="modal" data-bs-target="#editVoucherModal{{ $v->id }}">
                            <i class="bi bi-pencil-square"></i> Sửa
                        </button>
                        
                        <form method="post" action="{{ route('admin.vouchers.destroy', $v) }}" class="d-inline" onsubmit="return confirm('Xóa voucher này?')">@csrf @method('delete')
                            <button class="btn btn-sm btn-outline-danger fw-bold"><i class="bi bi-trash"></i> Xóa</button>
                        </form>
                    </td>
                </tr>

                <!-- Modal Sửa Voucher (Nằm trong vòng lặp để lấy đúng dữ liệu) -->
                <div class="modal fade" id="editVoucherModal{{ $v->id }}" tabindex="-1">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                      <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square"></i> Sửa Voucher: {{ $v->code }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <form method="post" action="{{ route('admin.vouchers.update', $v) }}">@csrf @method('put')
                      <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="fw-bold">Mã Code</label>
                            <input name="code" class="form-control form-control-lg bg-light text-uppercase" value="{{ $v->code }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Giảm giá (%)</label>
                            <input type="number" name="discount_percent" class="form-control form-control-lg bg-light" min="1" max="100" value="{{ $v->discount_percent }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Số lượt sử dụng tối đa</label>
                            <input type="number" name="max_uses" class="form-control form-control-lg bg-light" min="1" value="{{ $v->max_uses }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Ngày hết hạn</label>
                            <input type="date" name="expires_at" class="form-control form-control-lg bg-light" value="{{ $v->expires_at->format('Y-m-d') }}" required>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active_{{ $v->id }}" value="1" @checked($v->is_active)>
                            <label class="form-check-label fw-bold" for="is_active_{{ $v->id }}">Đang kích hoạt</label>
                        </div>
                      </div>
                      <div class="modal-footer border-0">
                        <button type="submit" class="btn btn-warning btn-lg w-100 rounded-pill fw-bold text-dark">Lưu thay đổi</button>
                      </div>
                      </form>
                    </div>
                  </div>
                </div>
                @empty
                <tr><td colspan="6" class="text-center py-4 text-muted">Chưa có voucher nào</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $vouchers->links() }}
    </div>
</div>

<!-- Modal Thêm Voucher -->
<div class="modal fade" id="addVoucherModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title fw-bold">Tạo mã giảm giá</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form method="post" action="{{ route('admin.vouchers.store') }}">@csrf
      <div class="modal-body p-4">
        <div class="mb-3">
            <label class="fw-bold">Mã Code (Viết liền, không dấu)</label>
            <input name="code" class="form-control form-control-lg bg-light text-uppercase" placeholder="VD: LUONGGIA20" required>
        </div>
        <div class="mb-3">
            <label class="fw-bold">Giảm giá (%)</label>
            <input type="number" name="discount_percent" class="form-control form-control-lg bg-light" min="1" max="100" value="10" required>
        </div>
        <div class="mb-3">
            <label class="fw-bold">Số lượt sử dụng tối đa</label>
            <input type="number" name="max_uses" class="form-control form-control-lg bg-light" min="1" value="100" required>
        </div>
        <div class="mb-3">
            <label class="fw-bold">Ngày hết hạn</label>
            <input type="date" name="expires_at" class="form-control form-control-lg bg-light" required>
        </div>
      </div>
      <div class="modal-footer border-0">
        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold">Lưu Voucher</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection 