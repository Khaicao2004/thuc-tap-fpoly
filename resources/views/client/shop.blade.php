@extends('client.layouts.master')

@section('title')
    Sản phẩm
@endsection

@section('content')
    @include('client.layouts.components.breadcrumb', ['pageName' => 'Sản phẩm', 'pageTitle' => 'Sản phẩm'])

    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="shop__sidebar">
                        <div class="shop__sidebar__search">
                            <form action="{{ route('search') }}" method="POST">
                                @csrf
                                <input type="text" name="name" placeholder="Search...">
                                <button type="submit"><span class="icon_search"></span></button>
                            </form>
                        </div>
                        <div class="shop__sidebar__accordion">
                            <div class="accordion" id="accordionExample">
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseOne">Danh mục</a>
                                    </div>
                                    <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__categories">
                                                <ul class="nice-scroll">
                                                    @foreach ($catalogues as $catalogue)
                                                        <li class="mb-1">
                                                            <a href="{{ route('shop', $catalogue->slug) }}"
                                                                class="d-flex"><span>{{ $catalogue->name }}</span>
                                                                <span
                                                                    class="text-black ml-auto">{{ $catalogue->products_count }}</span></a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-heading mb-3">
                                        <a data-toggle="collapse" data-target="#collapseFive">Sản phẩm</a>
                                    </div>
                                    <div id="collapseFive" class="collapse show" data-parent="#accordionExample">
                                        <form action="{{ route('filter') }}" method="POST">
                                            @csrf
                                            <div class="border p-4 rounded mb-4">
                                                <div class="mb-4">
                                                    <h3 class="mb-3 h6 text-uppercase text-black d-block">
                                                        Size
                                                    </h3>
                                                    @foreach ($sizes as $size)
                                                        <label for="s_sm" class="d-flex">
                                                            <input type="checkbox" id="s_sm" class="mr-2 mt-1" name="size[]"
                                                                value="{{ $size->id }}" />
                                                            <span class="text-black">{{ $size->name }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                    
                                                <div class="mb-4">
                                                    <h3 class="mb-3 h6 text-uppercase text-black d-block">
                                                        Color
                                                    </h3>
                                                    @foreach ($colors as $color)
                                                        <div class="d-flex color-item align-items-center">
                                                            <input type="checkbox" id="s_sm" class="mr-2 mt-1" name="color[]"
                                                                value="{{ $color->id }}" />
                                                            <span class=" color d-inline-block rounded-circle mr-2"
                                                                style="background: {{ $color->name }}"></span>
                                                            <span class="text-black">{{ $color->name }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="mt-3 mb-3">
                                                    <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                                                </div>
                                            </div>
                    
                                        </form>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseSix">Tags</a>
                                    </div>
                                    <div id="collapseSix" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__tags">
                                                @foreach ($tags as $id => $name)
                                                <a href="{{ route('shop', ['id' => $id ?? null, 'tagId' => $tagId ?? null]) }}">{{$name}}</a>                                           
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        @foreach ($products as $item)
                        @php
                            $url = $item->img_thumbnail;
                            if (!Str::contains($url, 'http')) {
                                $url = Storage::url($url);
                            }
                        @endphp
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="{{ $url }}">
                                    <span class="label">Sale</span>
                                </div>
                                <div class="product__item__text">
                                    <h6>{{ $item->name }}</h6>
                                    <a href="{{  route('shop.detail', $item->slug) }}" class="add-cart">+ Xem chi tiết</a>
                                    <div class="rating">
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                    </div>
                                    @if ($item->price_sale)
                                    <h5>{{ number_format($item->price_sale, 0, ',', '.') }}₫</h5>     
                                    @else
                                    <h5>{{ number_format($item->price_regular, 0, ',', '.') }}₫</h5>     
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                    <!-- <div class="row">
                            <div class="col-lg-12">
                                <div class="product__pagination">
                                    <a class="active" href="#">1</a>
                                    <a href="#">2</a>
                                    <a href="#">3</a>
                                    <span>...</span>
                                    <a href="#">21</a>
                                </div>
                            </div>
                        </div> -->
                </div>
            </div>
        </div>
    </section>
@endsection
