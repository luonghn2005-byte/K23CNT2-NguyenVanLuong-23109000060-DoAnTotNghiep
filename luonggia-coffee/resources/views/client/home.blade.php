<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>LuongGia Coffee - Đặt món Online</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { background-color: #f8f5f0; font-family: 'Nunito', sans-serif; color: #333; }
        .brand-font { font-family: 'Playfair Display', serif; }
        .hero { background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=2000') center/cover; height: 400px; display: flex; align-items: center; justify-content: center; color: white; border-bottom-left-radius: 40px; border-bottom-right-radius: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.15); }
        .product-card { transition: all 0.3s ease; cursor: pointer; border: 1px solid #eee; border-radius: 20px; overflow: hidden; background: #fff; position: relative; }
        .product-card:hover { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(0,0,0,0.08); border-color: #d4af37; }
        .product-img { height: 200px; object-fit: cover; width: 100%; transition: transform 0.5s ease; }
        .product-card:hover .product-img { transform: scale(1.05); }
        .btn-add { border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2rem; padding: 0; background: #d4af37; color: white; border: none; box-shadow: 0 4px 10px rgba(212, 175, 55, 0.4); transition: all 0.2s; }
        .btn-add:hover { background: #b8860b; transform: scale(1.1); color: white; }
        .cart-card { border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.06); background: #fff; }
        .cart-header { background: #fff; color: #333; border-bottom: 1px solid #eee; border-top-left-radius: 20px; border-top-right-radius: 20px; padding: 20px; }
        footer { background-color: #1a1a1a; color: #aaa; padding: 60px 0 20px 0; margin-top: 80px; border-top: 4px solid #d4af37; }
        footer h5 { color: #fff; font-family: 'Playfair Display', serif; margin-bottom: 20px; }
        footer a { color: #aaa; text-decoration: none; transition: 0.2s; }
        footer a:hover { color: #d4af37; }
        .floating-btn { position: fixed; bottom: 30px; right: 30px; border-radius: 50px; padding: 15px 30px; font-weight: bold; box-shadow: 0 10px 25px rgba(25, 135, 84, 0.5); z-index: 1000; display: none; }
    </style>
</head>
<body>

<div class="hero mb-5 position-relative">
    <div class="position-absolute top-0 end-0 p-4 d-flex align-items-center gap-2">
        @auth
            <span class="text-white me-2 fw-bold fs-6"><i class="bi bi-person-circle"></i> Chào, {{ auth()->user()->name }}</span>
            <form method="post" action="{{ route('client.logout') }}" class="d-inline">@csrf
                <button class="btn btn-sm btn-outline-light fw-bold rounded-pill">Đăng xuất</button>
            </form>
        @else
            <a href="{{ route('client.login') }}" class="btn btn-sm btn-light fw-bold rounded-pill px-3">Đăng nhập</a>
            <a href="{{ route('client.register') }}" class="btn btn-sm btn-warning fw-bold rounded-pill px-3">Đăng ký</a>
        @endauth
        <a href="{{ route('login') }}" class="btn btn-sm btn-danger fw-bold rounded-pill ms-2 px-3" title="Admin"><i class="bi bi-shield-lock"></i> Admin</a>
    </div>
    <div class="text-center w-100 mt-4">
        <h1 class="fw-bold display-2 brand-font" style="text-shadow: 2px 2px 10px rgba(0,0,0,0.5)">LuongGia Coffee</h1>
        <p class="fs-4 fw-light" style="letter-spacing: 2px;">HƯƠNG VỊ ĐẬM ĐÀ - KHÔNG GIAN TINH TẾ</p>
    </div>
</div>

<div class="container pb-5">
    <div class="row">
        <div class="col-lg-8">
            <h3 class="mb-4 brand-font text-dark fw-bold">Thực Đơn Hôm Nay</h3>
            @foreach($categories as $cat)
                <h5 class="mt-5 mb-3 text-warning fw-bold text-uppercase" style="font-size: 1rem; letter-spacing: 2px;"><i class="bi bi-caret-right-fill"></i> {{ $cat->name }}</h5>
                <div class="row g-4">
                    @foreach($cat->products as $p)
                    <div class="col-md-4 col-sm-6">
                        <div class="card product-card h-100" onclick="addToCart({{ $p->id }}, '{{ $p->name }}', {{ $p->price }})">
                            <img src="{{ $p->image ?? 'https://via.placeholder.com/300x200?text=No+Image' }}" class="product-img" alt="{{ $p->name }}">
                            <div class="card-body p-3">
                                <h6 class="fw-bold mb-1 text-dark text-truncate">{{ $p->name }}</h6>
                                <small class="text-muted d-block mb-3">Món ngon tuyển chọn</small>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-danger fw-bold fs-5">{{ number_format($p->price) }} đ</span>
                                    <button class="btn btn-add"><i class="bi bi-plus-lg"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        <div class="col-lg-4 mt-5 mt-lg-0">
            <div class="card cart-card sticky-top" style="top: 30px; z-index: 10;">
                <div class="cart-header d-flex justify-content-between align-items-center">
                    <span class="fw-bold fs-5 text-dark"><i class="bi bi-bag-heart-fill text-warning"></i> Đơn của bạn</span>
                    <span class="badge bg-dark rounded-pill" id="cart-badge">0 món</span>
                </div>
                <div class="card-body p-0" style="max-height: 350px; overflow-y: auto;">
                    <ul class="list-group list-group-flush" id="cart-list">
                        <li class="list-group-item text-center text-muted py-5 border-0" id="empty-cart">
                            <i class="bi bi-cup-hot fs-1 d-block mb-3 text-secondary opacity-25"></i>
                            <span class="fw-bold text-dark">Chưa có món nào</span><br>
                            <small>Hãy chọn cho mình một ly nước nhé!</small>
                        </li>
                    </ul>
                </div>
                <div class="card-footer bg-white p-4 border-top">
                    <div class="mb-3 border-bottom pb-3">
                        <label class="fw-bold text-muted small mb-1">Mã giảm giá (Voucher)</label>
                        <div class="input-group">
                            <input type="text" id="voucher-code" class="form-control text-uppercase" placeholder="Nhập mã...">
                            <button class="btn btn-outline-warning fw-bold" type="button" id="btn-apply-voucher">Áp dụng</button>
                        </div>
                        <small id="voucher-msg" class="d-block mt-1 fw-bold"></small>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Tạm tính:</span>
                        <span class="fw-bold text-dark" id="sub-total">0 đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Phí giao hàng:</span>
                        <span class="fw-bold text-success">Miễn phí</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Giảm giá:</span>
                        <span class="fw-bold text-success" id="discount-amount">- 0 đ</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fs-5 fw-bold text-dark">Tổng cộng:</span>
                        <span class="fs-4 fw-bold text-danger" id="total">0 đ</span>
                    </div>
                    <button class="btn btn-success w-100 py-3 fw-bold fs-6 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#checkoutModal" id="btn-checkout" disabled>TIẾN HÀNH ĐẶT HÀNG</button>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h5>LuongGia Coffee</h5>
                <p class="small">Hệ thống quản lý chuỗi quán coffee hiện đại. Mang đến cho khách hàng những trải nghiệm tuyệt vời nhất.</p>
            </div>
            <div class="col-md-4">
                <h5>Liên Hệ</h5>
                <ul class="list-unstyled small">
                    <li class="mb-2"><i class="bi bi-geo-alt-fill text-warning me-2"></i> 123 Nguyễn Huệ, Quận 1, TP.HCM</li>
                    <li class="mb-2"><i class="bi bi-telephone-fill text-warning me-2"></i> 0909 000 111</li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Giờ Mở Cửa</h5>
                <ul class="list-unstyled small">
                    <li class="mb-2 d-flex justify-content-between border-bottom border-secondary pb-2"><span>Thứ 2 - Thứ 6</span> <span class="text-white">07:00 - 22:00</span></li>
                    <li class="mb-2 d-flex justify-content-between border-bottom border-secondary pb-2"><span>Thứ 7 - Chủ Nhật</span> <span class="text-white">07:00 - 23:00</span></li>
                </ul>
            </div>
        </div>
        <div class="text-center mt-5 pt-3 border-top border-secondary small">&copy; {{ date('Y') }} LuongGia Coffee. Đồ án tốt nghiệp.</div>
    </div>
</footer>

<button class="btn btn-success floating-btn" data-bs-toggle="modal" data-bs-target="#checkoutModal" id="floating-checkout"><i class="bi bi-bag-check-fill"></i> Thanh toán (<span id="float-total">0</span> đ)</button>

<div class="modal fade" id="checkoutModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
      <div class="modal-header bg-dark text-white" style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
        <h5 class="modal-title fw-bold"><i class="bi bi-geo-alt"></i> Thông tin giao hàng</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="mb-3">
            <label class="fw-bold text-muted small">Họ tên người nhận</label>
            <input id="c_name" class="form-control form-control-lg bg-light" value="{{ auth()->check() ? auth()->user()->name : '' }}" required>
        </div>
        <div class="mb-3">
            <label class="fw-bold text-muted small">Số điện thoại</label>
            <input id="c_phone" class="form-control form-control-lg bg-light" required>
        </div>
        <div class="mb-3">
            <label class="fw-bold text-muted small">Địa chỉ nhận hàng</label>
            <input id="c_address" class="form-control form-control-lg bg-light" required>
        </div>
      </div>
      <div class="modal-footer border-0 p-4 pt-0">
        <button type="button" class="btn btn-light btn-lg rounded-pill fw-bold w-100" data-bs-dismiss="modal">Hủy</button>
        <button type="button" class="btn btn-success btn-lg rounded-pill fw-bold w-100" id="btn-submit-order">Xác nhận Đặt hàng</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let cart = {};
    let appliedVoucher = null;
    let discountPercent = 0;

    function addToCart(id, name, price) {
        if (cart[id]) { cart[id].qty++; } else { cart[id] = { name, price, qty: 1 }; }
        renderCart();
        const cartCard = document.querySelector('.cart-card');
        cartCard.style.transform = 'scale(1.02)';
        setTimeout(() => cartCard.style.transform = 'scale(1)', 200);
    }

    function removeItem(id) { delete cart[id]; renderCart(); }
    function changeQty(id, delta) {
        if (cart[id]) {
            cart[id].qty += delta;
            if (cart[id].qty <= 0) delete cart[id];
        }
        renderCart();
    }

    function renderCart() {
        const list = document.getElementById('cart-list');
        list.innerHTML = '';
        let total = 0;
        let count = 0;

        for (const id in cart) {
            const item = cart[id];
            const sub = item.price * item.qty;
            total += sub;
            count += item.qty;
            list.innerHTML += `
                <li class="list-group-item p-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold text-dark">${item.name}</span>
                        <button class="btn btn-sm text-danger" onclick="removeItem(${id})"><i class="bi bi-x-circle"></i></button>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="input-group input-group-sm rounded border" style="width: 100px;">
                            <button class="btn btn-light border-0" onclick="changeQty(${id}, -1)">-</button>
                            <input type="text" class="form-control text-center bg-white border-0" value="${item.qty}" readonly>
                            <button class="btn btn-light border-0" onclick="changeQty(${id}, 1)">+</button>
                        </div>
                        <span class="fw-bold text-danger">${sub.toLocaleString('vi-VN')} đ</span>
                    </div>
                </li>`;
        }

        if (count === 0) {
            list.innerHTML = `<li class="list-group-item text-center text-muted py-5 border-0" id="empty-cart"><i class="bi bi-cup-hot fs-1 d-block mb-3 text-secondary opacity-25"></i><span class="fw-bold text-dark">Chưa có món nào</span><br><small>Hãy chọn cho mình một ly nước nhé!</small></li>`;
            document.getElementById('btn-checkout').disabled = true;
            document.getElementById('floating-checkout').style.display = 'none';
        } else {
            document.getElementById('btn-checkout').disabled = false;
            document.getElementById('floating-checkout').style.display = 'block';
        }

        let discount = (total * discountPercent) / 100;
        let finalTotal = total - discount;

        document.getElementById('cart-badge').innerText = count + ' món';
        document.getElementById('sub-total').innerText = total.toLocaleString('vi-VN') + ' đ';
        document.getElementById('discount-amount').innerText = '- ' + discount.toLocaleString('vi-VN') + ' đ';
        document.getElementById('total').innerText = finalTotal.toLocaleString('vi-VN') + ' đ';
        document.getElementById('float-total').innerText = finalTotal.toLocaleString('vi-VN');
    }

    document.getElementById('btn-apply-voucher').addEventListener('click', function() {
        const code = document.getElementById('voucher-code').value;
        if (!code) return;
        fetch('{{ route("client.check_voucher") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ code: code })
        })
        .then(res => res.json())
        .then(data => {
            const msgEl = document.getElementById('voucher-msg');
            if (data.ok) {
                msgEl.className = 'd-block mt-1 fw-bold text-success';
                msgEl.innerText = data.msg;
                appliedVoucher = code;
                discountPercent = data.discount_percent;
            } else {
                msgEl.className = 'd-block mt-1 fw-bold text-danger';
                msgEl.innerText = data.msg;
                appliedVoucher = null;
                discountPercent = 0;
            }
            renderCart();
        });
    });

    document.getElementById('btn-submit-order').addEventListener('click', () => {
        const name = document.getElementById('c_name').value;
        const phone = document.getElementById('c_phone').value;
        const address = document.getElementById('c_address').value;
        if (!name || !phone || !address) return alert('Vui lòng điền đầy đủ thông tin!');
        if (Object.keys(cart).length === 0) return alert('Giỏ hàng trống!');

        const items = Object.keys(cart).map(id => ({ id: parseInt(id), qty: cart[id].qty }));
        const btn = document.getElementById('btn-submit-order');
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Đang xử lý...';
        btn.disabled = true;

        fetch('{{ route("client.checkout") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ name, phone, address, items, voucher_code: appliedVoucher })
        })
        .then(res => {
            if (!res.ok) throw new Error('Lỗi Server: ' + res.status);
            return res.json();
        })
        .then(data => {
            if (data.ok) {
                alert('Đặt hàng thành công! Mã đơn: ' + data.order_code);
                cart = {}; appliedVoucher = null; discountPercent = 0;
                document.getElementById('voucher-code').value = '';
                document.getElementById('voucher-msg').innerText = '';
                renderCart();
                bootstrap.Modal.getInstance(document.getElementById('checkoutModal')).hide();
            } else {
                alert('Có lỗi xảy ra: ' + (data.msg || 'Không xác định'));
            }
        })
        .catch(err => {
            alert('Không thể đặt hàng. Chi tiết lỗi: ' + err.message);
        })
        .finally(() => {
            btn.innerHTML = 'Xác nhận Đặt hàng';
            btn.disabled = false;
        });
    });
</script>
</body>
</html>