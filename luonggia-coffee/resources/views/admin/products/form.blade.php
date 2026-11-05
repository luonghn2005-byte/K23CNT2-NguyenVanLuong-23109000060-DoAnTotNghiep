@extends('layouts.app')
@section('content')
<style>
    body { background-color: #f4f6f9 !important; }
    .card { border-radius: 15px !important; border: none !important; box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important; }
</style>

<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow">
      <div class="card-header bg-white py-3 border-0">
        <h5 class="mb-0 fw-bold text-primary">
            <i class="bi bi-pencil-square"></i> {{ $item->exists ? 'Sửa' : 'Thêm' }} Sản phẩm
        </h5>
      </div>
      <div class="card-body p-4">
        <form method="post" action="{{ $item->exists ? route('admin.products.update', $item) : route('admin.products.store') }}">
          @csrf 
          @if($item->exists) @method('put') @endif
          
          <div class="mb-3">
            <label class="fw-bold text-muted small">Tên sản phẩm</label>
            <input name="name" class="form-control form-control-lg bg-light" value="{{ old('name', $item->name) }}" required placeholder="VD: Cà phê sữa đá...">
          </div>
          
          <div class="mb-3">
            <label class="fw-bold text-muted small">Danh mục</label>
            <select name="category_id" class="form-select form-select-lg bg-light" required>
              <option value="">-- Chọn danh mục --</option>
              @foreach($categories as $c)
              <option value="{{ $c->id }}" @selected(old('category_id', $item->category_id) == $c->id)>{{ $c->name }}</option>
              @endforeach
            </select>
          </div>
          
          <div class="mb-3">
            <label class="fw-bold text-muted small">Giá bán (VNĐ)</label>
            <input type="number" name="price" class="form-control form-control-lg bg-light" value="{{ old('price', $item->price) }}" required placeholder="VD: 30000">
          </div>

          <div class="mb-4">
            <label class="fw-bold text-muted small">Link ảnh sản phẩm (URL)</label>
            <input type="url" name="image" class="form-control bg-light" value="{{ old('image', $item->image) }}" placeholder="https://...">
            <small class="text-muted">Dán link ảnh từ Google hoặc Unsplash. Để trống nếu không có ảnh.</small>
          </div>
          
          <div class="text-end border-top pt-3">
            <a href="{{ route('admin.products.index') }}" class="btn btn-light border fw-bold px-4">Hủy</a>
            <button class="btn btn-primary fw-bold px-4"><i class="bi bi-save"></i> Lưu sản phẩm</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection