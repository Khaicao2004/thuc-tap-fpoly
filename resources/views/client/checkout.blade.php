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
                <form action="{{ route('order.save') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <h6 class="checkout__title">Chi tiết thanh toán</h6>
                            <div class="row">
                                <div class="col-12">
                                    <div class="checkout__input">
                                        <p>Họ và tên<span>*</span></p>
                                        <input type="text" name="user_name" id="user_name" class="form-control"
                                            value="{{ auth()->user()?->name }}">
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input">
                                <p>Address<span>*</span></p>
                                <input type="text" name="user_address" id="user_address" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Phone<span>*</span></p>
                                        <input type="text" name="user_phone" id="user_phone" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Email<span>*</span></p>
                                        <input type="text" name="user_email" id="user_email" class="form-control"
                                            value="{{ auth()->user()?->email }}">
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input">
                                <p>Ghi chú<span>*</span></p>
                                <input type="text" name="user_note" id="user_note" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
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
                                                <span>{{ $item['quantity'] * ($item['price_sale'] ?: $item['price_regular']) }}
                                                    đ</span>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                                <ul class="checkout__total__all">
                                    <li>Tổng đơn hàng <span>{{ number_format($totalAmount) }} đ</span></li>
                                </ul>
                                <button type="submit" class="site-btn">Tiến hành thanh toán</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
