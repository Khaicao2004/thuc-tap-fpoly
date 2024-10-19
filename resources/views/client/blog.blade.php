@extends('client.layouts.master')
@section('title')
    Tin tức
@endsection
@section('content')
    @include('client.layouts.components.breadcrumb', [
        'pageName' => 'Tin tức',
        'pageTitle' => 'Tin tức',
    ])
    <section class="blog spad">
        <div class="container">



            <div class="row">
                @foreach ($data as $item)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="blog__item">
                            <div class="blog__item__pic set-bg" data-setbg="{{ Storage::url($item->image) }}"></div>
                            <!-- Sử dụng Storage để lấy đường dẫn -->
                            <div class="blog__item__text">
                                <span><img src="/client/img/icon/calendar.png" alt="">
                                    {{ $item->created_at->format('d F Y') }}</span> <!-- Định dạng ngày -->
                                <h5>{{ $item->name }}</h5>
                                <p>{!! \Illuminate\Support\Str::limit($item->content, 100) !!}</p>
                                <!-- Tiêu đề bài viết -->
                                <a href="{{ route('blogs.show', $item->id) }}">Xem thêm</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
