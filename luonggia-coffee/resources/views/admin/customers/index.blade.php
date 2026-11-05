@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0 text-dark">👥 Quản lý Khách hàng</h4>
</div>

<div class="card">
    <div class="card-body p-4">
        
        <!-- Thanh tìm kiếm -->
        <form action="{{ route('admin.customers.index') }}" method="GET" class="mb-4 d-flex gap-2">
            <input type="text" name="search" class="form-control w-50" placeholder="Tìm theo tên hoặc email..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i> Tìm</button>
            @if(request('search'))
                <a href="{{ route('admin.customers.index') }}" class="btn btn-light border">Hủy tìm</a>
            @endif
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle border">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" width="70">ID</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Ngày tham gia</th>
                        <th class="text-end pe-4">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $c)
                    <tr>
                        <td class="text-center fw-bold text-muted">#{{ $c->id }}</td>
                        <td class="fw-bold text-dark"><i class="bi bi-person-circle text-primary"></i> {{ $c->name }}</td>
                        <td>{{ $c->email }}</td>
                        <td class="text-muted">{{ $c->created_at->format('d/m/Y') }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.customers.show', $c) }}" class="btn btn-sm btn-outline-primary fw-bold me-1">
                                <i class="bi bi-eye"></i> Xem chi tiết
                            </a>
                            <form method="post" action="{{ route('admin.customers.destroy', $c) }}" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa khách hàng này?')">@csrf @method('delete')
                                <button class="btn btn-sm btn-outline-danger fw-bold"><i class="bi bi-trash"></i> Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Chưa có khách hàng nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $customers->links() }}</div>
    </div>
</div>
@endsection