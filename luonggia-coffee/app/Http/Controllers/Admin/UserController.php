<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{User, Branch};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    public function index() {
        // Chỉ lấy những user KHÔNG PHẢI là khách hàng
        $users = User::with('branch')
            ->whereIn('role', ['admin', 'manager', 'staff']) 
            ->orderBy('id', 'desc')
            ->paginate(10);
            
        return view('admin.users.index', compact('users'));
    }

    public function create() {
        $branches = Branch::all();
        return view('admin.users.form', ['user' => new User(), 'branches' => $branches]);
    }

    public function store(Request $r) {
        $data = $r->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,manager,staff',
            'branch_id' => 'nullable|exists:branches,id',
        ]);

        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return redirect()->route('admin.users.index')->with('ok', 'Thêm nhân viên thành công!');
    }

    public function edit(User $user) {
        $branches = Branch::all();
        return view('admin.users.form', compact('user', 'branches'));
    }

    public function update(Request $r, User $user) {
        $data = $r->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,manager,staff',
            'branch_id' => 'nullable|exists:branches,id',
        ]);

        if ($r->filled('password')) {
            $r->validate(['password' => 'min:6']);
            $data['password'] = Hash::make($r->password);
        }

        $user->update($data);
        return redirect()->route('admin.users.index')->with('ok', 'Cập nhật nhân viên thành công!');
    }

    public function destroy(User $user) {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Bạn không thể tự xóa chính mình!']);
        }
        $user->delete();
        return back()->with('ok', 'Đã xóa nhân viên!');
    }
}