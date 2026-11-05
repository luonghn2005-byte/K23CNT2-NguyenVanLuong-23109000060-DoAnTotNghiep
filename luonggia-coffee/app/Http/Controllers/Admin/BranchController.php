<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller {
    public function index() {
        $branches = Branch::orderBy('id', 'desc')->paginate(10);
        return view('admin.branches.index', compact('branches'));
    }

    public function create() {
        return view('admin.branches.form', ['branch' => new Branch()]);
    }

    public function store(Request $r) {
        $data = $r->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);
        
        $data['is_active'] = $r->has('is_active') ? true : false;
        
        Branch::create($data);
        return redirect()->route('admin.branches.index')->with('ok', 'Thêm chi nhánh thành công!');
    }

    public function edit(Branch $branch) {
        return view('admin.branches.form', compact('branch'));
    }

    public function update(Request $r, Branch $branch) {
        $data = $r->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);
        
        $data['is_active'] = $r->has('is_active') ? true : false;
        
        $branch->update($data);
        return redirect()->route('admin.branches.index')->with('ok', 'Cập nhật chi nhánh thành công!');
    }

    public function destroy(Branch $branch) {
        $branch->delete();
        return back()->with('ok', 'Đã xóa chi nhánh!');
    }
}