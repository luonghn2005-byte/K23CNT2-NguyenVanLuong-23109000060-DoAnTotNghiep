<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','LuongGia Coffee')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        /* --- HIỆU ỨNG NỀN ĐỘNG GRADIENT CHO TOÀN HỆ THỐNG --- */
        body {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Lớp phủ trắng mờ để làm dịu nền, giúp nội dung dễ đọc */
        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(255, 255, 255, 0.75); /* Phủ trắng mờ 75% */
            backdrop-filter: blur(8px); /* Làm mờ hậu cảnh */
            z-index: -1;
        }

        /* Tùy chỉnh Navbar */
        .navbar {
            background-color: rgba(33, 37, 41, 0.95) !important; /* Nền đen mờ */
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .navbar-nav .nav-link {
            font-weight: 600;
            transition: all 0.2s;
            font-size: 0.9rem; /* Thu nhỏ chữ một chút để vừa đủ menu */
        }
        .navbar-nav .nav-link:hover {
            color: #ffc107 !important;
            transform: translateY(-1px);
        }
        .navbar-brand {
            font-weight: 800;
            letter-spacing: 1px;
            font-size: 1.3rem;
        }

        /* Card mặc định cho các trang con */
        .card {
            border-radius: 15px !important;
            border: none !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
            background-color: #ffffff !important;
        }
    </style>
</head>
<body class="bg-transparent">

<!-- Thanh điều hướng (Navbar) -->
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm fixed-top">
    <div class="container-fluid px-4">
        <a class="navbar-brand text-warning" href="{{ route('dashboard') }}">
            <i class="bi bi-cup-hot-fill"></i> LuongGia
        </a>
        
        @auth
        <div class="d-flex gap-3 align-items-center w-100 justify-content-between ms-4">
            <!-- Các menu chính -->
            <div class="navbar-nav flex-row gap-2">
                <a class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active fw-bold text-warning' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
                <a class="nav-link text-white {{ request()->routeIs('admin.orders.*') ? 'active fw-bold text-warning' : '' }}" href="{{ route('admin.orders.index') }}"><i class="bi bi-receipt"></i> Đơn hàng</a>
                <a class="nav-link text-white {{ request()->routeIs('admin.products.*') ? 'active fw-bold text-warning' : '' }}" href="{{ route('admin.products.index') }}"><i class="bi bi-cup-straw"></i> Sản phẩm</a>
                <a class="nav-link text-white {{ request()->routeIs('admin.branches.*') ? 'active fw-bold text-warning' : '' }}" href="{{ route('admin.branches.index') }}"><i class="bi bi-shop"></i> Chi nhánh</a>
                <a class="nav-link text-white {{ request()->routeIs('admin.users.*') ? 'active fw-bold text-warning' : '' }}" href="{{ route('admin.users.index') }}"><i class="bi bi-people"></i> Nhân viên</a>
                <a class="nav-link text-white {{ request()->routeIs('admin.customers.*') ? 'active fw-bold text-warning' : '' }}" href="{{ route('admin.customers.index') }}"><i class="bi bi-person-lines-fill"></i> Khách hàng</a>
                <a class="nav-link text-white {{ request()->routeIs('admin.vouchers.*') ? 'active fw-bold text-warning' : '' }}" href="{{ route('admin.vouchers.index') }}"><i class="bi bi-ticket-perforated"></i> Voucher</a>
                <a class="nav-link text-warning fw-bold {{ request()->routeIs('pos.*') ? 'bg-warning text-dark px-3 rounded' : '' }}" href="{{ route('pos.index') }}"><i class="bi bi-cart3"></i> POS</a>
            </div>

            <!-- Thông tin User & Đăng xuất -->
            <div class="d-flex align-items-center border-start border-secondary ps-3">
                <span class="text-light me-3"><i class="bi bi-person-circle"></i> {{ auth()->user()->name }}</span>
                <form method="post" action="{{ route('logout') }}" class="mb-0">@csrf
                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-box-arrow-right"></i> Thoát</button>
                </form>
            </div>
        </div>
        @endauth
    </div>
</nav>

<!-- Nội dung chính (Cách navbar 100px để không bị che) -->
<div class="container" style="padding-top: 100px; padding-bottom: 50px;">
    <!-- Thông báo thành công -->
    @if(session('ok'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('ok') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Thông báo lỗi -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Vùng chứa nội dung của từng trang -->
    @yield('content')
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Vùng chứa Script của các trang con -->
@stack('scripts')
</body>
</html>