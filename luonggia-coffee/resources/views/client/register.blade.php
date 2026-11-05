<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Đăng ký Khách hàng - LuongGia Coffee</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.7)), 
                        url('https://images.unsplash.com/photo-1497935586351-b67a49e012bf?q=80&w=2000&auto=format&fit=crop') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-y: auto;
            padding: 20px 0;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            padding: 40px;
            width: 100%;
            max-width: 450px;
            color: white;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        .register-card h4 {
            font-weight: 700;
            text-align: center;
            margin-bottom: 25px;
            letter-spacing: 1px;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 10px;
            padding: 12px;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.25);
            color: white;
            border-color: #198754;
            box-shadow: 0 0 10px rgba(25, 135, 84, 0.3);
        }

        .form-control::placeholder { color: rgba(255, 255, 255, 0.6); }
        .form-label { font-weight: 500; font-size: 0.9rem; color: #e0e0e0; }

        .btn-register {
            background: linear-gradient(45deg, #20c997, #198754);
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 10px;
            padding: 12px;
            width: 100%;
            margin-top: 10px;
            transition: all 0.3s;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(25, 135, 84, 0.4);
            color: white;
        }

        a { color: #20c997; text-decoration: none; transition: 0.2s; }
        a:hover { color: #48e5b7; text-decoration: underline; }
    </style>
</head>
<body>

    <div class="register-card">
        <h4><i class="bi bi-person-plus-fill"></i> Đăng ký tài khoản</h4>
        
        @if($errors->any())
            <div class="alert alert-danger py-2 text-center" style="background: rgba(220, 53, 69, 0.8); color: white; border: none;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="post" action="{{ route('client.register') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Họ và tên</label>
                <input name="name" class="form-control" placeholder="Nhập họ tên của bạn..." value="{{ old('name') }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input name="email" type="email" class="form-control" placeholder="Nhập email..." value="{{ old('email') }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Mật khẩu</label>
                <input name="password" type="password" class="form-control" placeholder="Tối thiểu 6 ký tự..." required>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Nhập lại mật khẩu</label>
                <input name="password_confirmation" type="password" class="form-control" placeholder="Nhập lại mật khẩu..." required>
            </div>
            
            <button class="btn btn-register">Tạo tài khoản</button>
        </form>
        
        <div class="text-center mt-4">
            <p class="mb-1 small">Đã có tài khoản? <a href="{{ route('client.login') }}">Đăng nhập</a></p>
            <p class="mb-0 small"><a href="{{ route('client.home') }}" class="text-white opacity-75"><i class="bi bi-arrow-left"></i> Quay lại trang chủ</a></p>
        </div>
    </div>

</body>
</html>