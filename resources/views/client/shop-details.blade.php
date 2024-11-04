@extends('client.layouts.master')

@section('title')
    Chi tiết sản phẩm
@endsection
@section('content')
    @include('client.layouts.components.breadcrumb', [
        'pageName' => 'Chi tiết sản phẩm',
        'pageTitle' => 'Chi tiết sản phẩm',
    ])
    <!-- Shop Details Section Begin -->
    <section class="shop-details">
        <div class="product__details__pic">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <ul class="nav nav-tabs" role="tablist">
                            @foreach ($galleries as $id => $image)
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">
                                        <div class="product__thumb__pic set-bg" data-setbg="{{ Storage::url($image) }}">
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-lg-6 col-md-9">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__pic__item">
                                    @php
                                        $url = $product->img_thumbnail;
                                        if (!Str::contains($url, 'http')) {
                                            $url = Storage::url($url);
                                        }
                                    @endphp
                                    <img src="{{ $url }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product__details__content">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8">
                        <div class="product__details__text">
                            <h4>{{ $product->name }}</h4>
                            <div class="rating-summary">
                                <h4>Đánh giá trung bình: {{ round($averageRating, 1) }} / 5</h4>
                                <p>Dựa trên {{ $ratingCount }} đánh giá</p>
                                <div class="rating-stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span
                                            class="star {{ $i <= round($averageRating, 0) ? 'selected' : '' }}">&#9733;</span>
                                    @endfor
                                </div>
                            </div>


                            <h3>
                                {{ number_format($product->price_sale, 0, ',', '.') }}đ
                                <span> {{ number_format($product->price_regular, 0, ',', '.') }}đ</span>
                            </h3>
                            <p>{{ $product->description }}</p>
                            <form action="{{ route('cart.add') }}" method="post">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="product__details__option">
                                    <div class="product__details__option__size">
                                        <span><b>Size:</b></span>
                                        @foreach ($sizes as $id => $name)
                                            <input type="radio" class="mx-2" name="product_size_id"
                                                value="{{ $id }}">{{ $name }}
                                        @endforeach
                                    </div>
                                    <div class="product__details__option__size">
                                        <span><b>Color:</b></span>
                                        @foreach ($colors as $id => $name)
                                            <input type="radio" class="mx-2" name="product_color_id"
                                                value="{{ $id }}">{{ $name }}
                                        @endforeach
                                    </div>
                                </div>
                                <div class="product__details__cart__option">
                                    <div class="quantity">
                                        <div class="pro-qty">
                                            <input type="number" name="quantity" value="1">
                                        </div>
                                    </div>
                                    <button type="submit" class="primary-btn mt-3">add to cart</button>
                                </div>
                            </form>

                            <div class="product__details__last__option">
                                <ul>
                                    <li><span>SKU:</span> {{ $product->sku }}</li>
                                    <li><span>Cata:</span> {{ $product->catalogue->name }}</li>
                                    <li><span>Tag:</span>
                                        @foreach ($product->tags as $item)
                                            {{ $item->name }}
                                        @endforeach
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product__details__content">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="product__details__tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#tabs-5" role="tab">Nội
                                                dung</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#tabs-6" role="tab">Chất
                                                liệu</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#tabs-7" role="tab">
                                                Hướng dẫn sử dụng</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#tabs-8" role="tab">
                                                Comments</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tabs-5" role="tabpanel">
                                            <div class="product__details__tab__content">
                                                @php
                                                    $contents = explode("\n", $product->content);
                                                @endphp

                                                @foreach ($contents as $content)
                                                    <p>{!! $content !!}</p>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tabs-6" role="tabpanel">
                                            <div class="product__details__tab__content">
                                                <div class="product__details__tab__content__item">
                                                    <p>{!! nl2br(e($product->material)) !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tabs-7" role="tabpanel">
                                            <div class="product__details__tab__content">
                                                <p>{!! nl2br(e($product->user_manual)) !!}</p>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="tabs-8" role="tabpanel">

                                            <div class="product__details__tab__content">
                                                @if (Auth::check())
                                                    @php
                                                        // Kiểm tra xem người dùng đã mua sản phẩm này chưa
                                                        $hasPurchased = \App\Models\OrderItem::whereHas(
                                                            'order',
                                                            function ($query) {
                                                                $query->where('user_id', Auth::id());
                                                            },
                                                        )
                                                            ->whereHas('productVariant', function ($query) use (
                                                                $product,
                                                            ) {
                                                                $query->where('product_id', $product->id);
                                                            })
                                                            ->exists();
                                                    @endphp

                                                    @if ($hasPurchased)
                                                        <form action="{{ route('comment.store') }}" method="post">
                                                            @csrf
                                                            <div class='row'>
                                                                <div class='col-md-12'>
                                                                    <div class='form-group'>
                                                                        <input type='hidden' name="product_id"
                                                                            value="{{ $product->id }}">
                                                                        <label for="rating">Đánh giá:</label>
                                                                        <div class="rating-product">
                                                                            <span class="star"
                                                                                data-value="1">&#9733;</span>
                                                                            <span class="star"
                                                                                data-value="2">&#9733;</span>
                                                                            <span class="star"
                                                                                data-value="3">&#9733;</span>
                                                                            <span class="star"
                                                                                data-value="4">&#9733;</span>
                                                                            <span class="star"
                                                                                data-value="5">&#9733;</span>
                                                                        </div>
                                                                        <input type="hidden" id="rating-value"
                                                                            name="rating" value="" required>
                                                                        <textarea id='for_comment' name="content" class='form-control' placeholder='Bình luận sản phẩm....'></textarea>
                                                                        <input type="submit" name='gui'
                                                                            value='Bình Luận'>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    @else
                                                        {{-- <p>Bạn mua hàng để đánh giá sản phẩm.</p> --}}
                                                    @endif
                                                @else
                                                    <p>Bạn chưa: <a href="{{ route('login') }}"
                                                            class="btn btn-primary custom-btn">Đăng nhập</a>
                                                    </p>
                                                @endif

                                                @if ($comments->isEmpty())
                                                    <p>Chưa có bình luận nào.</p>
                                                @else
                                                    <div class="table-comment">
                                                        @foreach ($comments as $comment)
                                                            <div class="box-comment">
                                                                <div class="col-md-12 ten">
                                                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRVia42F18wBAiCKkeMnPjOhOwA53yDFlBBGQ&s"
                                                                        alt=""
                                                                        style="border-radius: 50%; width: 30px; height: 30px; object-fit: cover; border: 1px rgb(181, 171, 171) solid;">
                                                                    <h4>{{ $comment->user->name }}</h4>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <p>Đã bình luận vào ngày:
                                                                        {{ $comment->created_at->format('d/m/Y H:i') }}</p>
                                                                </div>
                                                                <div class="col-md-12 noidung">
                                                                    <p>{{ $comment->content }}</p>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Details Section End -->

    <!-- Related Section Begin -->
    <section class="related spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="related-title">Related Products</h3>
                </div>
            </div>
            <div class="row">
                @foreach ($relatedProducts as $item)
                    @php
                        $url = $item->img_thumbnail;
                        // Kiểm tra URL của ảnh, nếu không có 'http' thì sử dụng Storage URL
                        if (!Str::contains($url, 'http')) {
                            $url = Storage::url($url);
                        }
                    @endphp
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="{{ $url }}">
                                <span class="label">New</span>
                                <ul class="product__hover">
                                    <li><a href="#"><img src="/theme/client/img/icon/heart.png" alt=""></a>
                                    </li>
                                    <li><a href="#"><img src="/theme/client/img/icon/compare.png"
                                                alt=""><span>Compare</span></a></li>
                                    <li><a href="#"><img src="/theme/client/img/icon/search.png"
                                                alt=""></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6>{{ $item->name }}</h6>
                                <a href="{{ route('shop.detail', $item->slug) }}" class="add-cart">+ View Details</a>

                                <!-- Hiển thị tổng trung bình sao -->
                                <div class="rating-summary">
                                    <div class="rating-stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span
                                                class="star {{ $i <= round($item->averageRating) ? 'selected' : '' }}">&#9733;</span>
                                        @endfor
                                        <p>{{ round($item->averageRating, 1) }} / 5 ({{ $item->ratingCount }} reviews)</p>

                                    </div>
                                </div>

                                <!-- Hiển thị giá sản phẩm -->
                                @if ($item->price_sale)
                                    <h5>{{ number_format($item->price_sale, 0, ',', '.') }}đ</h5>
                                @else
                                    <h5>{{ number_format($item->price_regular, 0, ',', '.') }}đ</h5>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
@endsection
