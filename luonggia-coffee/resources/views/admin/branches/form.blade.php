@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow">
      <div class="card-header bg-white py-3 border-0">
        <h5 class="mb-0 fw-bold text-primary">
            <i class="bi bi-shop"></i> {{ $branch->exists ? 'Sửa' : 'Thêm' }} Chi nhánh
        </h5>
      </div>
      <div class="card-body p-4">
        <form method="post" action="{{ $branch->exists ? route('admin.branches.update', $branch) : route('admin.branches.store') }}">
          @csrf 
          @if($branch->exists) @method('put') @endif
          
          <div class="mb-3">
            <label class="fw-bold text-muted small">Tên chi nhánh</label>
            <input name="name" class="form-control form-control-lg bg-light" value="{{ old('name', $branch->name) }}" required placeholder="VD: LuongGia - Quận 1">
          </div>
          
          <div class="mb-3">
            <label class="fw-bold text-muted small">Địa chỉ</label>
            <input name="address" class="form-control form-control-lg bg-light" value="{{ old('address', $branch->address) }}" required placeholder="Số nhà, đường, quận...">
          </div>
          
          <div class="mb-3">
            <label class="fw-bold text-muted small">Số điện thoại</label>
            <input name="phone" class="form-control form-control-lg bg-light" value="{{ old('phone', $branch->phone) }}" placeholder="VD: 0909123456">
          </div>

          <div class="mb-4 form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" @checked(old('is_active', $branch->is_active ?? true))>
            <label class="form-check-label fw-bold" for="is_active">Đang hoạt động (Mở cửa bán hàng)</label>
          </div>
          
          <div class="text-end border-top pt-3">
            <a href="{{ route('admin.branches.index') }}" class="btn btn-light border fw-bold px-4">Hủy</a>
            <button class="btn btn-primary fw-bold px-4"><i class="bi bi-save"></i> Lưu chi nhánh</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection