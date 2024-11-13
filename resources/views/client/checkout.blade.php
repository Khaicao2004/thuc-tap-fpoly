@extends('client.layouts.master')

@section('title')
    Thanh toán
@endsection

@section('content')
    @include('client.layouts.components.breadcrumb', [
        'pageName' => 'Thanh toán',
        'pageTitle' => 'Thanh toán',
    ])
    <section class="checkout spad">
        <div class="container">
            <div class="checkout__form">
                <div class="row">
                    <div class="col-lg-8 col-md-6 mb-3">
                        <form action="{{ route('order.save') }}" method="POST" id="paymentForm">
                            @csrf
                            <h6 class="checkout__title">Chi tiết thanh toán</h6>
                        
                            <!-- Thông tin người dùng -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="checkout__input">
                                        <p>Họ và tên<span>*</span></p>
                                        <input type="text" name="user_name" id="user_name" class="form-control" value="{{ auth()->user()?->name }}">
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input">
                                <p>Địa chỉ<span>*</span></p>
                                <input type="text" name="user_address" id="user_address" class="form-control" value="{{ auth()->user()?->address }}">
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Số điện thoại<span>*</span></p>
                                        <input type="text" name="user_phone" id="user_phone" class="form-control" value="{{ auth()->user()?->phone }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Email<span>*</span></p>
                                        <input type="text" name="user_email" id="user_email" class="form-control" value="{{ auth()->user()?->email }}">
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input">
                                <p>Ghi chú<span>*</span></p>
                                <input type="text" name="user_note" id="user_note" class="form-control">
                            </div>
                            <div class="row">
                                <input type="hidden" name="total" value="{{ $totalAmount }}">
                                
                                <!-- Nút thanh toán thông thường -->
                                <button type="button" class="site-btn mr-3" id="normalPaymentBtn">Tiến hành thanh toán</button>
                        
                                @if (Auth::check())
                                    <!-- Nút thanh toán online -->
                                    <button type="button" class="btn btn-warning" id="onlinePaymentBtn">Thanh toán online</button>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="checkout__discount mb-3">
                            <h6>Mã giảm giá</h6>
                            <form action="{{ route('apply.coupon') }}" method="POST" class="styled-coupon-form">
                                @csrf
                                <div class="input-group">
                                    <input type="text" class="form-control coupon-input" placeholder="Nhập mã giảm giá"
                                        name="name">
                                    <button type="submit" class="btn btn-apply">Áp dụng</button>
                                </div>
                            </form>
                        </div>
                        <div class="checkout__order">
                            <h4 class="order__title">Đơn hàng của bạn</h4>
                            <div class="checkout__order__products">Sản phẩm <span>Tổng giá</span></div>
                            <ul class="checkout__total__products">
                                @if (session()->has('cart'))
                                    @php
                                        $stt = 0;
                                    @endphp
                                    @foreach (session('cart') as $item)
                                        <li>{{ $stt += 1 }}. {{ $item['name'] }}
                                            <span>{{ $item['quantity'] * $item['price'] }} đ</span>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                            <ul class="checkout__total__all">
                                @if (session()->has('coupon'))
                                    <li>Tổng đơn hàng:
                                        <span>{{ number_format(session('coupon.totalAmountBeforeDiscount')) }}
                                            đ</span>
                                    </li>
                                    <li>Giá trị mã: <span>
                                            @if (session('coupon.discount_type') == 'percent_cart' || session('coupon.discount_type') == 'percent_product')
                                                {{ session('coupon.discount_value') }} %
                                            @else
                                                {{ number_format(session('coupon.discount_value')) }} đ
                                            @endif
                                        </span></li>
                                    <li>Số tiền được giảm:
                                        <span>
                                            @if (session('coupon.discount_type') == 'percent_cart' || session('coupon.discount_type') == 'percent_product')
                                                {{ number_format(session('coupon.discount')) }} đ
                                            @else
                                                {{ number_format(session('coupon.discount')) }} đ
                                            @endif
                                        </span>
                                        <form action="{{ route('remove.coupon') }}" method="post"
                                            style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger"
                                                style="border: none; background-color: transparent; padding: 0; cursor: pointer;">
                                                <i class="fa-solid fa-circle-xmark"
                                                    style="font-size: 24px; color: red;"></i>
                                            </button>
                                        </form>
                                    </li>
                                    <li>Tổng đơn hàng sau khi
                                        giảm<span>{{ number_format(session('coupon.totalAmountAfterDiscount')) }} đ</span>
                                    </li>
                                @else
                                    <li>Tổng đơn hàng <span>{{ number_format($totalAmount) }} đ</span></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('styles')
    <style>
        .btn-danger:hover .fa-circle-xmark {
            color: darkred;
            /* Thay đổi màu khi hover */
            transform: scale(1.2);
            /* Tăng kích thước khi hover */
            transition: transform 0.2s ease, color 0.2s ease;
            /* Thêm hiệu ứng chuyển động */
        }

        .checkout__discount {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            text-align: center;
            max-width: 400px;
            margin: 0 auto;
        }

        .checkout__discount h6 {
            font-size: 1.6rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .styled-coupon-form {
            display: flex;
            justify-content: center;
        }

        .input-group {
            display: flex;
            border-radius: 50px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .coupon-input {
            flex: 1;
            padding: 15px 20px;
            font-size: 1rem;
            border: none;
            outline: none;
            transition: box-shadow 0.3s ease, background-color 0.3s ease;
        }

        .coupon-input:focus {
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.3);
            background-color: #fff;
        }

        .btn-apply {
            padding: 0 25px;
            background-color: #28a745;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-apply:hover {
            background-color: #218838;
        }

        @media (max-width: 576px) {
            .checkout__discount {
                padding: 15px;
                max-width: 100%;
            }

            .input-group {
                flex-direction: column;
            }

            .coupon-input,
            .btn-apply {
                border-radius: 50px;
            }

            .btn-apply {
                margin-top: 10px;
            }
        }
    </style>
@endsection

@section('js')
    <script>
        // Khi người dùng chọn thanh toán thông thường
        document.getElementById('normalPaymentBtn').addEventListener('click', function(e) {
            e.preventDefault();
            
            // Chuyển hành động của form đến route thanh toán thông thường
            document.getElementById('paymentForm').action = "{{ route('order.save') }}";
            
            // Gửi form thanh toán thông thường
            document.getElementById('paymentForm').submit();
        });

        // Khi người dùng chọn thanh toán online
        document.getElementById('onlinePaymentBtn').addEventListener('click', function(e) {
            e.preventDefault();
            
            // Chuyển hành động của form đến route thanh toán online
            document.getElementById('paymentForm').action = "{{ url('/vnpay_payment') }}";

            // Thêm dữ liệu thanh toán online nếu cần (ví dụ: tổng tiền)
            let form = document.getElementById('paymentForm');
            let totalInput = document.querySelector('input[name="total"]');
            form.appendChild(totalInput);

            // Gửi form thanh toán online
            form.submit();
        });
    </script>
@endsection
