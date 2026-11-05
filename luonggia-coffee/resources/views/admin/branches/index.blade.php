@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0 text-dark">🏬 Quản lý Chi nhánh</h4>
    <a href="{{ route('admin.branches.create') }}" class="btn btn-primary fw-bold rounded-pill px-4 shadow-sm">
        <i class="bi bi-plus-lg"></i> Thêm chi nhánh
    </a>
</div>

<div class="card">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle border">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" width="70">ID</th>
                        <th>Tên chi nhánh</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-end pe-4">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($branches as $b)
                    <tr>
                        <td class="text-center fw-bold text-muted">#{{ $b->id }}</td>
                        <td class="fw-bold text-dark"><i class="bi bi-shop text-primary"></i> {{ $b->name }}</td>
                        <td class="text-muted">{{ $b->address }}</td>
                        <td>{{ $b->phone ?? '-' }}</td>
                        <td class="text-center">
                            @if($b->is_active)
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Đang hoạt động</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">Tạm khóa</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.branches.edit', $b) }}" class="btn btn-sm btn-outline-warning fw-bold me-1">
                                <i class="bi bi-pencil-square"></i> Sửa
                            </a>
                            <form method="post" action="{{ route('admin.branches.destroy', $b) }}" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa chi nhánh này?')">@csrf @method('delete')
                                <button class="btn btn-sm btn-outline-danger fw-bold"><i class="bi bi-trash"></i> Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Chưa có chi nhánh nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $branches->links() }}</div>
    </div>
</div>
@endsection