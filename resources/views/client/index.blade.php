@extends('client.layouts.master')

@section('title')
    Trang chủ
@endsection

@section('content')
    <!-- Header Section End -->

    @include('client.layouts.partials.banner')

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="filter__controls">
                        <li class="active" data-filter="*">Best Sellers</li>
                        <li data-filter=".new-arrivals">New Arrivals</li>
                        <li data-filter=".hot-deals">Hot Deals</li>
                        <li data-filter=".good-deals">Good Deals</li>
                    </ul>
                </div>
            </div>
            <div class="row product__filter">
                @foreach ($productNews as $new)
                    <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix new-arrivals">
                        <div class="product__item">
                    @php
                        $url = $new->img_thumbnail;
                        if (!Str::contains($url, 'http')) {
                            $url = Storage::url($url);
                        }
                    @endphp
                            <div class="product__item__pic set-bg" data-setbg="{{ $url }}">
                                <span class="label">New</span>
                                <ul class="product__hover">
                                    <li><a href="#"><img src="/theme/client/img/icon/heart.png" alt=""></a>
                                    </li>
                                    <li><a href="#"><img src="/theme/client/img/icon/compare.png" alt="">
                                            <span>Compare</span></a></li>
                                    <li><a href="#"><img src="/theme/client/img/icon/search.png" alt=""></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6>{{ $new->name }}</h6>
                                <a href="{{ route('shop.detail', $new->slug) }}" class="add-cart">+ Xem chi tiết</a>
                                <div class="rating-summary">
                                    <div class="rating-stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span class="star {{ $i <= round($new->averageRating) ? 'selected' : '' }}">&#9733;</span>
                                        @endfor
                                        <p>{{ round($new->averageRating, 1) }} / 5 ({{ $new->comments->count() }} reviews)</p> <!-- Sử dụng $new->comments->count() để lấy tổng số đánh giá -->
                                    </div>
                                </div>
                                @if ($new->price_sale)
                                    <h5>
                                        {{ number_format($new->price_sale, 0, ',', '.') }}đ
                                    </h5>
                                @else
                                    <h5>
                                        {{ number_format($new->price_regular, 0, ',', '.') }}đ
                                    </h5>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

                @foreach ($productHotDeals as $hotDeal)
                    <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix hot-deals">
                        <div class="product__item">
                            @php
                                $url = $hotDeal->img_thumbnail;
                                if (!Str::contains($url, 'http')) {
                                    $url = Storage::url($url);
                                }
                            @endphp
                            <div class="product__item__pic set-bg" data-setbg="{{ $url }}">
                                <span class="label">HOT</span>
                                <ul class="product__hover">
                                    <li><a href="#"><img src="/theme/client/img/icon/heart.png" alt=""></a>
                                    </li>
                                    <li><a href="#"><img src="/theme/client/img/icon/compare.png" alt="">
                                            <span>Compare</span></a></li>
                                    <li><a href="#"><img src="/theme/client/img/icon/search.png" alt=""></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6>{{ $hotDeal->name }}</h6>
                                <a href="{{ route('shop.detail', $hotDeal->slug) }}" class="add-cart">+ Xem chi tiết</a>
                                <div class="rating-summary">
                                    <div class="rating-stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span class="star {{ $i <= round($hotDeal->averageRating) ? 'selected' : '' }}">&#9733;</span>
                                        @endfor
                                        <p>{{ round($hotDeal->averageRating, 1) }} / 5 ({{ $hotDeal->comments->count() }} reviews)</p> <!-- Sử dụng $new->comments->count() để lấy tổng số đánh giá -->
                                    </div>
                                </div>
                                @if ($hotDeal->price_sale)
                                    <h5>
                                        {{ number_format($hotDeal->price_sale, 0, ',', '.') }}đ
                                    </h5>
                                @else
                                    <h5>
                                        {{ number_format($hotDeal->price_regular, 0, ',', '.') }}đ
                                    </h5>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

                @foreach ($productGoodDeals as $goodDeal)
                    <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix good-deals">
                        <div class="product__item sale">
                            @php
                                $url = $goodDeal->img_thumbnail;
                                if (!Str::contains($url, 'http')) {
                                    $url = Storage::url($url);
                                }
                            @endphp
                            <div class="product__item__pic set-bg" data-setbg="{{ $url }}">
                                <span class="label">GOOD</span>
                                <ul class="product__hover">
                                    <li><a href="#"><img src="/theme/client/img/icon/heart.png" alt=""></a>
                                    </li>
                                    <li><a href="#"><img src="/theme/client/img/icon/compare.png" alt="">
                                            <span>Compare</span></a></li>
                                    <li><a href="#"><img src="/theme/client/img/icon/search.png" alt=""></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6>{{ $goodDeal->name }}</h6>
                                <a href="{{ route('shop.detail', $goodDeal->slug) }}" class="add-cart">+ Xem chi tiết</a>
                                <div class="rating-summary">
                                    <div class="rating-stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span class="star {{ $i <= round($goodDeal->averageRating) ? 'selected' : '' }}">&#9733;</span>
                                        @endfor
                                        <p>{{ round($goodDeal->averageRating, 1) }} / 5 ({{ $goodDeal->comments->count() }} reviews)</p> <!-- Sử dụng $new->comments->count() để lấy tổng số đánh giá -->
                                    </div>
                                </div>
                                @if ($goodDeal->price_sale)
                                    <h5>
                                        {{ number_format($goodDeal->price_sale, 0, ',', '.') }}đ
                                    </h5>
                                @else
                                    <h5>
                                        {{ number_format($goodDeal->price_regular, 0, ',', '.') }}đ
                                    </h5>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Product Section End -->

    <!-- Categories Section Begin -->
    <section class="categories spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="categories__text">
                        <h2>Clothings Hot <br /> <span>Shoe Collection</span> <br /> Accessories</h2>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="categories__hot__deal">
                        <img src="/theme/client/img/product-sale.png" alt="">
                        <div class="hot__deal__sticker">
                            <span>Sale Of</span>
                            <h5>$29.99</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-1">
                    <div class="categories__deal__countdown">
                        <span>Deal Of The Week</span>
                        <h2>Multi-pocket Chest Bag Black</h2>
                        <div class="categories__deal__countdown__timer" id="countdown">
                            <div class="cd-item">
                                <span>3</span>
                                <p>Days</p>
                            </div>
                            <div class="cd-item">
                                <span>1</span>
                                <p>Hours</p>
                            </div>
                            <div class="cd-item">
                                <span>50</span>
                                <p>Minutes</p>
                            </div>
                            <div class="cd-item">
                                <span>18</span>
                                <p>Seconds</p>
                            </div>
                        </div>
                        <a href="#" class="primary-btn">Shop now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section End -->

    <!-- Instagram Section Begin -->
    <section class="instagram spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="instagram__pic">
                        <div class="instagram__pic__item set-bg" data-setbg="/theme/client/img/instagram/instagram-1.jpg">
                        </div>
                        <div class="instagram__pic__item set-bg" data-setbg="/theme/client/img/instagram/instagram-2.jpg">
                        </div>
                        <div class="instagram__pic__item set-bg" data-setbg="/theme/client/img/instagram/instagram-3.jpg">
                        </div>
                        <div class="instagram__pic__item set-bg" data-setbg="/theme/client/img/instagram/instagram-4.jpg">
                        </div>
                        <div class="instagram__pic__item set-bg" data-setbg="/theme/client/img/instagram/instagram-5.jpg">
                        </div>
                        <div class="instagram__pic__item set-bg" data-setbg="/theme/client/img/instagram/instagram-6.jpg">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="instagram__text">
                        <h2>Instagram</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua.</p>
                        <h3>#Male_Fashion</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Instagram Section End -->

    <!-- Latest Blog Section Begin -->
    <section class="latest spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Tin tức mới nhất</span>
                        <h2>Xu hướng thời trang</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($blogs as $item)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="blog__item">
                            <div class="blog__item__pic set-bg" data-setbg="{{ Storage::url($item->image) }}"></div>
                            <div class="blog__item__text">
                                <span><img src="/theme/client/img/icon/calendar.png" alt="">
                                    {{ $item->created_at->format('d F Y') }}</span>
                                <h5>{{ $item->name }}</h5>
                                <a href="{{ route('blogs.show', $item->id) }}">Xem thêm</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Latest Blog Section Begin -->
    @include('client.layouts.partials.blog')
    <!-- Latest Blog Section End -->
@endsection
