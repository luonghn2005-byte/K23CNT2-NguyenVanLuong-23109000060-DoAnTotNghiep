<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientAuthController extends Controller {
    // Hiển thị form đăng nhập khách hàng
    public function showLogin() { return view('client.login'); }

    // Xử lý đăng nhập
    public function login(Request $r) {
        $data = $r->validate(['email'=>'required|email','password'=>'required']);
        if (Auth::attempt($data)) {
            $r->session()->regenerate();
            // Nếu là khách hàng thì về trang chủ, nếu là admin thì về dashboard
            if (auth()->user()->role === 'customer') {
                return redirect('/');
            }
            return redirect('/admin/dashboard');
        }
        return back()->withErrors(['email'=>'Email hoặc mật khẩu sai'])->onlyInput('email');
    }

    // Hiển thị form đăng ký
    public function showRegister() { return view('client.register'); }

    // Xử lý đăng ký
    public function register(Request $r) {
        $data = $r->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'customer'; // Mặc định là khách hàng

        User::create($data);

        return redirect('/client/login')->with('ok', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }

    // Đăng xuất
    public function logout(Request $r) {
        Auth::logout(); 
        $r->session()->invalidate(); 
        $r->session()->regenerateToken();
        return redirect('/');
    }
}