@extends('layouts.app')
@section('content')
<style>
    .pos-card { background-color: #ffffff !important; border-radius: 15px; border: none; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
    .product-btn { background: #fff; border: 1px solid #e0e0e0; border-radius: 12px; padding: 0; overflow: hidden; transition: all 0.2s; text-align: left; display: flex; flex-direction: column; height: 100%; }
    .product-btn:hover { border-color: #0d6efd; box-shadow: 0 8px 20px rgba(13, 110, 253, 0.15); transform: translateY(-3px); }
    .product-img { height: 110px; width: 100%; object-fit: cover; }
    .product-info { padding: 10px 12px; }
    .cart-item-img { width: 40px; height: 40px; object-fit: cover; border-radius: 8px; margin-right: 10px; border: 1px solid #eee; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0 text-dark"><i class="bi bi-shop-window text-warning"></i> Bán hàng tại quầy (POS)</h4>
</div>

<div class="row g-4">
  <div class="col-md-7">
    <div class="row g-3">
      @foreach($products as $p)
      <div class="col-md-4 col-sm-6">
        <button class="btn product-btn w-100 product-action" data-id="{{ $p->id }}" data-name="{{ $p->name }}" data-price="{{ $p->price }}" data-image="{{ $p->image }}">
            <img src="{{ $p->image ?? 'https://via.placeholder.com/200x150?text=No+Img' }}" class="product-img" alt="{{ $p->name }}">
            <div class="product-info w-100">
                <div class="fw-bold text-dark text-truncate" style="font-size: 0.95rem;">{{ $p->name }}</div>
                <div class="text-danger fw-bold mt-1">{{ number_format($p->price) }} đ</div>
            </div>
        </button>
      </div>
      @endforeach
    </div>
  </div>

  <div class="col-md-5">
    <div class="card pos-card sticky-top" style="top: 100px; z-index: 10;">
      <div class="card-header bg-dark text-white fw-bold py-3 d-flex justify-content-between align-items-center">
        <span><i class="bi bi-cart3"></i> Giỏ hàng</span>
        <span class="badge bg-warning text-dark rounded-pill" id="cart-badge">0 món</span>
      </div>
      
      <div class="card-body p-0" style="max-height: 350px; overflow-y: auto;">
        <ul class="list-group list-group-flush" id="cart-list">
            <li class="list-group-item text-center text-muted py-5 border-0" id="empty-cart">
                <i class="bi bi-basket fs-1 d-block mb-2 text-secondary opacity-50"></i>Chưa có món nào
            </li>
        </ul>
      </div>
      
      <div class="card-footer bg-white py-4 border-top">
        <!-- Phần Voucher -->
        <div class="mb-3">
            <div class="input-group">
                <input type="text" id="voucher-code" class="form-control text-uppercase" placeholder="Nhập mã giảm giá...">
                <button class="btn btn-outline-warning fw-bold" type="button" id="btn-apply-voucher">Áp dụng</button>
            </div>
            <small id="voucher-msg" class="d-block mt-1 fw-bold"></small>
        </div>

        <!-- Tính tiền -->
        <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Tạm tính:</span>
            <span class="fw-bold text-dark" id="sub-total">0 đ</span>
        </div>
        <div class="d-flex justify-content-between mb-3">
            <span class="text-muted">Giảm giá:</span>
            <span class="fw-bold text-success" id="discount-amount">- 0 đ</span>
        </div>
        <hr>
        <div class="d-flex justify-content-between mb-3">
            <h5 class="mb-0 fw-bold text-dark">Tổng cộng:</h5>
            <h4 class="mb-0 fw-bold text-danger" id="total">0 đ</h4>
        </div>

        <!-- Phương thức thanh toán -->
        <div class="mb-3">
            <label class="fw-bold text-muted small mb-2">Phương thức thanh toán</label>
            <div class="d-flex gap-3">
                <div class="form-check flex-grow-1 border rounded p-2 bg-light">
                    <input class="form-check-input ms-0 me-2" type="radio" name="payment" id="pay_cash" value="cash" checked>
                    <label class="form-check-label fw-bold text-dark" for="pay_cash"><i class="bi bi-cash-coin text-success"></i> Tiền mặt</label>
                </div>
                <div class="form-check flex-grow-1 border rounded p-2 bg-light">
                    <input class="form-check-input ms-0 me-2" type="radio" name="payment" id="pay_transfer" value="transfer">
                    <label class="form-check-label fw-bold text-dark" for="pay_transfer"><i class="bi bi-bank text-primary"></i> Chuyển khoản</label>
                </div>
            </div>
        </div>

        <button id="btn-checkout" class="btn btn-success w-100 py-3 fw-bold fs-5 rounded-pill shadow-sm mt-2">
            <i class="bi bi-credit-card"></i> Thanh toán (F1)
        </button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  let cart = {};
  let appliedVoucher = null;
  let discountPercent = 0;

  document.querySelectorAll('.product-action').forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.dataset.id;
      const name = btn.dataset.name;
      const price = parseInt(btn.dataset.price);
      const image = btn.dataset.image;

      if (cart[id]) { cart[id].qty++; } 
      else { cart[id] = { name: name, price: price, image: image, qty: 1 }; }
      renderCart();
    });
  });

  function renderCart() {
    const list = document.getElementById('cart-list');
    list.innerHTML = '';
    let total = 0;
    let count = 0;

    for (const id in cart) {
      const item = cart[id];
      const subtotal = item.price * item.qty;
      total += subtotal;
      count += item.qty;
      
      list.innerHTML += `
        <li class="list-group-item p-3 border-bottom">
            <div class="d-flex align-items-center mb-2">
                <img src="${item.image ?? 'https://via.placeholder.com/40'}" class="cart-item-img">
                <div class="flex-grow-1">
                    <div class="fw-bold text-dark" style="font-size: 0.95rem;">${item.name}</div>
                    <small class="text-muted">${item.price.toLocaleString('vi-VN')} đ</small>
                </div>
                <button class="btn btn-sm text-danger" onclick="removeItem(${id})"><i class="bi bi-x-circle"></i></button>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-2">
                <div class="input-group input-group-sm rounded border" style="width: 110px;">
                    <button class="btn btn-light border-0" onclick="changeQty(${id}, -1)">-</button>
                    <input type="text" class="form-control text-center bg-white border-0" value="${item.qty}" readonly>
                    <button class="btn btn-light border-0" onclick="changeQty(${id}, 1)">+</button>
                </div>
                <span class="fw-bold text-danger">${subtotal.toLocaleString('vi-VN')} đ</span>
            </div>
        </li>
      `;
    }

    if (count === 0) {
        list.innerHTML = `<li class="list-group-item text-center text-muted py-5 border-0" id="empty-cart"><i class="bi bi-basket fs-1 d-block mb-2 text-secondary opacity-50"></i>Chưa có món nào</li>`;
    }

    let discount = (total * discountPercent) / 100;
    let finalTotal = total - discount;

    document.getElementById('cart-badge').innerText = count + ' món';
    document.getElementById('sub-total').innerText = total.toLocaleString('vi-VN') + ' đ';
    document.getElementById('discount-amount').innerText = '- ' + discount.toLocaleString('vi-VN') + ' đ';
    document.getElementById('total').innerText = finalTotal.toLocaleString('vi-VN') + ' đ';
  }

  // Xử lý Voucher
  document.getElementById('btn-apply-voucher').addEventListener('click', function() {
    const code = document.getElementById('voucher-code').value;
    if (!code) return;
    fetch('{{ route("pos.check_voucher") }}', {
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

  window.changeQty = function(id, delta) {
    if (cart[id]) {
        cart[id].qty += delta;
        if (cart[id].qty <= 0) delete cart[id];
    }
    renderCart();
  }

  window.removeItem = function(id) { delete cart[id]; renderCart(); };

  // Thanh toán
  document.getElementById('btn-checkout').addEventListener('click', () => {
    const items = Object.keys(cart).map(id => ({ id: parseInt(id), qty: cart[id].qty }));
    if (items.length === 0) return alert('Giỏ hàng đang trống!');

    const paymentMethod = document.querySelector('input[name="payment"]:checked').value;
    const btn = document.getElementById('btn-checkout');
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Đang xử lý...';
    btn.disabled = true;

    fetch('{{ route("pos.checkout") }}', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
      body: JSON.stringify({ items: items, voucher_code: appliedVoucher, payment_method: paymentMethod })
    })
    .then(res => res.json())
    .then(data => {
      if (data.ok) {
        alert('Thanh toán thành công! Mã đơn: ' + data.order_code);
        cart = {}; appliedVoucher = null; discountPercent = 0;
        document.getElementById('voucher-code').value = '';
        document.getElementById('voucher-msg').innerText = '';
        renderCart();
      }
    })
    .catch(err => alert('Có lỗi xảy ra!'))
    .finally(() => {
        btn.innerHTML = '<i class="bi bi-credit-card"></i> Thanh toán (F1)';
        btn.disabled = false;
    });
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'F1') { e.preventDefault(); document.getElementById('btn-checkout').click(); }
  });
</script>
@endpush