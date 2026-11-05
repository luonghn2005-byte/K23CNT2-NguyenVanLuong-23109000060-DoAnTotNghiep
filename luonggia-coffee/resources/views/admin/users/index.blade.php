@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4>👥 Quản lý Nhân viên</h4>
  <a href="{{ route('admin.users.create') }}" class="btn btn-primary">+ Thêm nhân viên</a>
</div>

@if(session('ok'))<div class="alert alert-success">{{ session('ok') }}</div>@endif
@if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif

<table class="table table-bordered table-hover align-middle">
  <thead class="table-dark">
    <tr><th>ID</th><th>Họ tên</th><th>Email</th><th>Vai trò</th><th>Chi nhánh</th><th>Hành động</th></tr>
  </thead>
  <tbody>
    @foreach($users as $u)
    <tr>
      <td>{{ $u->id }}</td>
      <td class="fw-bold">{{ $u->name }}</td>
      <td>{{ $u->email }}</td>
      <td>
        <span class="badge bg-{{ $u->role == 'admin' ? 'danger' : ($u->role == 'manager' ? 'warning' : 'secondary') }}">
          {{ strtoupper($u->role) }}
        </span>
      </td>
      <td>{{ $u->branch->name ?? 'Chưa phân bổ' }}</td>
      <td>
        <a href="{{ route('admin.users.edit', $u) }}" class="btn btn-sm btn-warning">Sửa</a>
        <form method="post" action="{{ route('admin.users.destroy', $u) }}" class="d-inline" onsubmit="return confirm('Xóa nhân viên này?')">@csrf @method('delete')
          <button class="btn btn-sm btn-danger">Xóa</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
<div class="mt-3">{{ $users->links() }}</div>
@endsection