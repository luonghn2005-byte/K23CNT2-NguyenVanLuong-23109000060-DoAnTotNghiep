<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Đăng nhập - LuongGia Coffee</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.8)), 
                        url('https://images.unsplash.com/photo-1554118811-1e0d58224f24?q=80&w=2047&auto=format&fit=crop') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow: hidden;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 24px;
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.6);
            padding: 45px;
            width: 100%;
            max-width: 420px;
            color: white;
            animation: fadeInDown 0.8s ease-out;
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-card h3 {
            font-weight: 800;
            text-align: center;
            margin-bottom: 5px;
            letter-spacing: 2px;
            color: #fff;
        }
        
        .typing-text {
            text-align: center;
            font-size: 0.85rem;
            color: #d4af37;
            margin-bottom: 30px;
            height: 20px;
            letter-spacing: 1px;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 12px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border-color: #d4af37;
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.3);
        }

        .form-control::placeholder { color: rgba(255, 255, 255, 0.5); }
        .form-label { font-weight: 500; font-size: 0.9rem; color: #ccc; }

        .input-group-text {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-left: none;
            color: #aaa;
            cursor: pointer;
            border-radius: 0 12px 12px 0;
        }
        .input-group .form-control { border-right: none; border-radius: 12px 0 0 12px; }

        .btn-login {
            background: linear-gradient(45deg, #b8860b, #d4af37);
            border: none;
            color: #1a1a1a;
            font-weight: bold;
            border-radius: 12px;
            padding: 14px;
            width: 100%;
            margin-top: 15px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(212, 175, 55, 0.4);
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.85);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 0.9rem;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
    </style>
</head>
<body>

    <div class="login-card">
        <h3>☕ LUONGGIA</h3>
        <div class="typing-text" id="typing"></div>
        
        @if($errors->any())
            <div class="alert alert-danger text-center">{{ $errors->first() }}</div>
        @endif

        <form method="post" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input name="email" type="email" class="form-control" placeholder="admin@luonggia.vn" value="{{ old('email', 'admin@luonggia.vn') }}" required>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Mật khẩu</label>
                <div class="input-group">
                    <input name="password" type="password" id="password" class="form-control" placeholder="••••••••" value="12345678" required>
                    <span class="input-group-text" id="togglePassword">
                        <i class="bi bi-eye-slash" id="eyeIcon"></i>
                    </span>
                </div>
            </div>
            
            <button type="submit" class="btn btn-login">ĐĂNG NHẬP</button>

            <!-- Nút quay lại trang khách hàng -->
            <div class="text-center mt-3">
                <a href="{{ route('client.home') }}" class="text-warning text-decoration-none small">
                    <i class="bi bi-arrow-left"></i> Quay lại trang đặt món của Khách
                </a>
            </div>
        </form>
    </div>

    <script>
        const text = "HỆ THỐNG QUẢN LÝ CHUỖI QUÁN";
        let i = 0;
        function typeWriter() {
            if (i < text.length) {
                document.getElementById("typing").innerHTML += text.charAt(i);
                i++;
                setTimeout(typeWriter, 50);
            }
        }
        window.onload = typeWriter;

        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            eyeIcon.classList.toggle('bi-eye');
            eyeIcon.classList.toggle('bi-eye-slash');
        });
    </script>

</body>
</html>