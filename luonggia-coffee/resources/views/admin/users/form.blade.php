@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">{{ $user->exists ? 'Sửa' : 'Thêm' }} Tài khoản Nhân viên</h5>
      </div>
      <div class="card-body">
        <form method="post" action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}">
          @csrf 
          @if($user->exists) @method('put') @endif
          
          <div class="mb-3">
            <label class="fw-bold">Họ và tên</label>
            <input name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
          </div>
          
          <div class="mb-3">
            <label class="fw-bold">Email (Tài khoản đăng nhập)</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
          </div>

          <div class="mb-3">
            <label class="fw-bold">Mật khẩu {{ $user->exists ? '(Để trống nếu không đổi)' : '' }}</label>
            <input type="password" name="password" class="form-control" {{ $user->exists ? '' : 'required' }}>
          </div>
          
          <div class="mb-3">
            <label class="fw-bold">Vai trò</label>
            <select name="role" class="form-select" required>
              <option value="admin" @selected(old('role', $user->role) == 'admin')>Quản trị viên (Admin)</option>
              <option value="manager" @selected(old('role', $user->role) == 'manager')>Quản lý (Manager)</option>
              <option value="staff" @selected(old('role', $user->role) == 'staff')>Nhân viên (Staff)</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="fw-bold">Chi nhánh làm việc</label>
            <select name="branch_id" class="form-select">
              <option value="">-- Chưa phân bổ --</option>
              @foreach($branches as $b)
              <option value="{{ $b->id }}" @selected(old('branch_id', $user->branch_id) == $b->id)>{{ $b->name }}</option>
              @endforeach
            </select>
          </div>
          
          <div class="text-end">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Hủy</a>
            <button class="btn btn-success">Lưu tài khoản</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection