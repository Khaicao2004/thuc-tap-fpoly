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
                                    @foreach (session('cart') as $item)
                                        <tr>
                                            <td class="product__cart__item">
                                                <div class="product__cart__item__pic">
                                                    <img src="{{ Storage::url($item['img_thumbnail']) }}" width="80px"
                                                        height="80px">
                                                </div>
                                                <div class="product__cart__item__text">
                                                    <h6>{{ $item['name'] }}</h6>
                                                    @if ($item['price_sale'])
                                                        <h5>
                                                            {{ $item['price_sale'] }}đ
                                                        </h5>
                                                    @else
                                                        <h5>
                                                            {{ $item['price_regular'] }} đ
                                                        </h5>
                                                    @endif
                                                    <span><b>Color:</b> {{ $item['color']['name'] }}</span><br>
                                                    <span><b>Size:</b> {{ $item['size']['name'] }}</span>
                                                </div>
                                            </td>
                                            <td class="quantity__item">
                                                <div class="quantity">
                                                    <div class="pro-qty-2">
                                                        <input type="text" value="{{ $item['quantity'] }}">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="cart__price">
                                                {{ number_format($item['quantity'] * ($item['price_sale'] ?: $item['price_regular'])) }}
                                                đ</td>
                                            <td class="cart__close">
                                                <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Xóa"
                                                        onclick="return confirm('Bạn có muốn xóa không?');">
                                                        <i class="fa fa-close"></i>
                                                    </button>
                                                </form>
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
@endsection
