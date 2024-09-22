@extends('client.layouts.master')

@section('title')
    Giỏ hàng
@endsection

@section('content')
    @include('client.layouts.components.breadcrumb', ['pageName' => 'Giỏ hàng', 'pageTitle' => 'Giỏ hàng'])
    <!-- Shopping Cart Section Begin -->
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="shopping__cart__table">
                        <table>
                            <thead>
                                @if (session()->has('cart'))
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                        <th></th>
                                    </tr>
                                @else
                                @endif
                            </thead>
                            <tbody>
                                @if (session()->has('cart'))
                                    {{-- @dd(session('cart')); --}}
                                    @foreach (session('cart') as $variantId => $item)
                                        <tr id="cart-item-{{ $variantId }}">
                                            <td class="product__cart__item">
                                                <div class="product__cart__item__pic">
                                                    <img src="{{ Storage::url($item['img_thumbnail']) }}" width="80px"
                                                        height="80px">
                                                </div>
                                                <div class="product__cart__item__text">
                                                    <h6>{{ $item['name'] }}</h6>
                                                    <h5>{{ $item['price'] }}</h5>
                                                    <span><b>Color:</b> {{ $item['color']['name'] }}</span><br>
                                                    <span><b>Size:</b> {{ $item['size']['name'] }}</span>
                                                </div>
                                            </td>
                                            <td class="quantity__item">
                                                <div class="quantity">
                                                    <div class="input-group" style="width: 120px;">
                                                        <div class="input-group-prepend">
                                                            <button type="button" class="btn btn-primary btn-sm btn-minus"
                                                                data-variant-id="{{ $variantId }}" style="width: 30px;">
                                                                –
                                                            </button>
                                                        </div>
                                                        <input type="number"
                                                            class="form-control text-center product-quantity"
                                                            value="{{ $item['quantity'] }}" min="1" max="100"
                                                            style="height: 30px; padding: 0;" readonly />
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn btn-primary btn-sm btn-plus"
                                                                data-variant-id="{{ $variantId }}" style="width: 30px;">
                                                                +
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="cart__price">
                                                <span
                                                    class="item-total">{{ number_format($item['quantity'] * $item['price']) }}</span>
                                                đ
                                            </td>
                                            <td class="cart__close">
                                                <button class="btn btn-danger btn-sm" title="Xóa"
                                                    onclick="removeFromCart({{ $variantId }})">
                                                    <i class="fa fa-close"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <h5>Không có sản phẩm nào trong giỏ hàng.</h5>
                                @endif
                            </tbody>

                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="continue__btn">
                                <a href="{{ route('home') }}">Tiếp tục mua hàng</a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cart__total">
                        <h6>Tổng giỏ hàng</h6>
                        <ul>
                            <li>Tổng tiền <span>{{ number_format($totalAmount) }} đ </span></li>
                        </ul>
                        <a href="{{ route('checkout') }}" class="primary-btn">Tiến hành thanh toán</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function removeFromCart(variantId) {
            if (confirm('Bạn có muốn xóa không?')) {
                console.log(`Fetching URL: {{ route('cart.remove', '') }}/${variantId}`);
                fetch(`{{ route('cart.remove', '') }}/${variantId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        }
                    })
                    .then(response => {
                        console.log('Response:', response);
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Data:', data);
                        if (data.success) {
                            document.getElementById(`cart-item-${variantId}`).remove();
                            document.querySelector('.cart__total span').innerText = `${data.totalAmount} đ`;
                        } else {
                            alert('Không thể xóa sản phẩm.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }
    </script>

    {{-- <script>
        function updateQuantity(variantId, newQuantity) {
            fetch(`http://thuc-tap-fpoly.test/cart/update/${variantId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        quantity: newQuantity,
                    }),
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Cập nhật số lượng trong trường nhập
                        document.querySelector(`#cart-item-${variantId} .product-quantity`).value = data
                            .adjustedQuantity;

                        // Cập nhật giá tổng cho sản phẩm
                        document.querySelector(`#cart-item-${variantId} .item-total`).innerText =
                            `${number_format(data.itemTotal)} `;

                        // Cập nhật tổng số tiền giỏ hàng
                        document.querySelector('.cart__total span').innerText = `${number_format(data.totalAmount)} `;

                        if (data.message) {
                            alert(data.message);
                        }
                    } else {
                        alert('Cập nhật không thành công: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Thêm sự kiện cho nút "+"
        document.querySelectorAll('.btn-plus').forEach(button => {
            button.addEventListener('click', function() {
                let variantId = this.dataset.variantId;
                let currentQuantity = parseInt(document.querySelector(
                    `#cart-item-${variantId} .product-quantity`).value);
                let newQuantity = currentQuantity + 1; // Tăng số lượng
                updateQuantity(variantId, newQuantity);
            });
        });

        // Thêm sự kiện cho nút "–"
        document.querySelectorAll('.btn-minus').forEach(button => {
            button.addEventListener('click', function() {
                let variantId = this.dataset.variantId;
                let currentQuantity = parseInt(document.querySelector(
                    `#cart-item-${variantId} .product-quantity`).value);

                // Kiểm tra nếu currentQuantity lớn hơn 1
                if (currentQuantity > 1) {
                    let newQuantity = currentQuantity - 1; // Giảm số lượng
                    updateQuantity(variantId, newQuantity);
                } else {
                    alert('Số lượng không thể giảm xuống dưới 1.');
                }
            });
        });
    </script> --}}

    <script>
        function number_format(number) {
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(number);
        }

        function updateQuantity(variantId, newQuantity) {
            fetch(`http://thuc-tap-fpoly.test/cart/update/${variantId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        quantity: newQuantity,
                    }),
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Cập nhật số lượng trong trường nhập
                        document.querySelector(`#cart-item-${variantId} .product-quantity`).value = data
                            .adjustedQuantity;

                        // Cập nhật giá tổng cho sản phẩm
                        document.querySelector(`#cart-item-${variantId} .item-total`).innerText =
                            `${number_format(data.itemTotal)}`;

                        // Cập nhật tổng số tiền giỏ hàng
                        document.querySelector('.cart__total span').innerText = `${number_format(data.totalAmount)}`;
                    } else {
                        alert('Cập nhật không thành công: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Thêm sự kiện cho nút "+"
        document.querySelectorAll('.btn-plus').forEach(button => {
            button.addEventListener('click', function() {
                let variantId = this.dataset.variantId;
                let currentQuantity = parseInt(document.querySelector(
                    `#cart-item-${variantId} .product-quantity`).value);

                // Gọi hàm cập nhật số lượng
                updateQuantity(variantId, currentQuantity + 1);
            });
        });

        // Thêm sự kiện cho nút "–"
        document.querySelectorAll('.btn-minus').forEach(button => {
            button.addEventListener('click', function() {
                let variantId = this.dataset.variantId;
                let currentQuantity = parseInt(document.querySelector(
                    `#cart-item-${variantId} .product-quantity`).value);

                // Kiểm tra nếu currentQuantity lớn hơn 1
                if (currentQuantity > 1) {
                    updateQuantity(variantId, currentQuantity - 1);
                } else {
                    alert('Số lượng không thể giảm xuống dưới 1.');
                }
            });
        });
    </script>


@endsection
