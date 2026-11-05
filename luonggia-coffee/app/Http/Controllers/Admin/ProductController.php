<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Product, Category};
use Illuminate\Http\Request;

class ProductController extends Controller {
    public function index(Request $request) {
        $query = Product::with('category');

        // Chức năng tìm kiếm
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $items = $query->orderBy('id', 'desc')->paginate(10);
        return view('admin.products.index', compact('items'));
    }

    public function create() {
        $categories = Category::all();
        return view('admin.products.form', ['item' => new Product(), 'categories' => $categories]);
    }

    public function store(Request $r) {
        $data = $r->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|url'
        ]);
        Product::create($data);
        return redirect()->route('admin.products.index')->with('ok', 'Thêm sản phẩm thành công!');
    }

    public function edit(Product $product) {
        $categories = Category::all();
        return view('admin.products.form', ['item' => $product, 'categories' => $categories]);
    }

    public function update(Request $r, Product $product) {
        $data = $r->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|url'
        ]);
        $product->update($data);
        return redirect()->route('admin.products.index')->with('ok', 'Cập nhật sản phẩm thành công!');
    }

    public function destroy(Product $product) {
        $product->delete();
        return back()->with('ok', 'Đã xóa sản phẩm!');
    }
}