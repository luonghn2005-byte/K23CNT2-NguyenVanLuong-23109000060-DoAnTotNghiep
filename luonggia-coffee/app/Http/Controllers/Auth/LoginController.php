<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
    // Hiển thị form đăng nhập
    public function show() { 
        return view('auth.login'); 
    }

    // Xử lý đăng nhập
    public function login(Request $r) {
        $data = $r->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($data)) {
            $r->session()->regenerate();
            // Chuyển hướng về trang quản trị (đã đổi thành /admin/dashboard)
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.'
        ])->onlyInput('email');
    }

    // Xử lý đăng xuất
    public function logout(Request $r) {
        Auth::logout(); 
        $r->session()->invalidate(); 
        $r->session()->regenerateToken();
        
        // Đăng xuất xong quay về trang đăng nhập
        return redirect('/login');
    }
}