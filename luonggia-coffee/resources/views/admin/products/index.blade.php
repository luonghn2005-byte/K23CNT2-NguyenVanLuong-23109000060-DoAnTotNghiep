@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0 text-dark">☕ Quản lý Sản phẩm</h4>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary fw-bold rounded-pill px-4 shadow-sm">
        <i class="bi bi-plus-lg"></i> Thêm sản phẩm
    </a>
</div>

<div class="card">
    <div class="card-body p-4">
        
        <!-- Thanh tìm kiếm -->
        <form action="{{ route('admin.products.index') }}" method="GET" class="mb-4 d-flex gap-2">
            <input type="text" name="search" class="form-control w-50" placeholder="Tìm kiếm theo tên sản phẩm..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i> Tìm</button>
            @if(request('search'))
                <a href="{{ route('admin.products.index') }}" class="btn btn-light border">Hủy tìm</a>
            @endif
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle border">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" width="70">ID</th>
                        <th width="80">Ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Giá bán</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-end pe-4">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $p)
                    <tr>
                        <td class="text-center fw-bold text-muted">#{{ $p->id }}</td>
                        <td>
                            <img src="{{ $p->image ?? 'https://via.placeholder.com/50?text=No+Img' }}" class="rounded border" style="width: 50px; height: 50px; object-fit: cover;" alt="img">
                        </td>
                        <td class="fw-bold text-dark">{{ $p->name }}</td>
                        <td><span class="badge bg-light text-dark border px-2 py-1">{{ $p->category->name ?? '-' }}</span></td>
                        <td class="fw-bold text-danger">{{ number_format($p->price) }} đ</td>
                        <td class="text-center">
                            @if($p->is_active)
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Đang bán</span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">Ngừng bán</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.products.edit', $p) }}" class="btn btn-sm btn-outline-warning fw-bold me-1" title="Sửa">
                                <i class="bi bi-pencil-square"></i> Sửa
                            </a>
                            <form method="post" action="{{ route('admin.products.destroy', $p) }}" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">@csrf @method('delete')
                                <button class="btn btn-sm btn-outline-danger fw-bold" title="Xóa">
                                    <i class="bi bi-trash"></i> Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Không tìm thấy sản phẩm nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $items->links() }}
        </div>
    </div>
</div>
@endsection