@extends('client.layouts.master')
@section('title')
    Chi tiết tin tức
@endsection
@section('content')
    @include('client.layouts.components.breadcrumb', [
        'pageName' => 'Chi tiết tin tức',
        'pageTitle' => 'Chi tiết tin tức',
    ])
    <!-- Blog Details Hero Begin -->
    <section class="blog-hero spad">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-9 text-center">
                    <div class="blog__hero__text">
                        <h2>{{ $blog->name }}</h2>
                        <ul>
                            <li>By Deercreative</li>
                            <li>February 21, 2019</li>
                            <li>8 Comments</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Hero End -->

    <!-- Blog Details Section Begin -->
    <section class="blog-details spad">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-12">
                    <div class="blog__details__pic">
                        <img src="{{ Storage::url($blog->image) }}" alt="{{ $blog->name }}">
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="blog__details__content">
                        <div class="blog__details__share">
                            <span>share</span>
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#" class="twitter"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#" class="youtube"><i class="fa fa-youtube-play"></i>
                                        {{ $blog->created_at->format('d F Y') }}</a></li>
                                <li><a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a></li>
                            </ul>
                        </div>
                        <div class="blog__details__text">
                            {!! $blog->content !!}
                        </div>

                        <div class="blog__details__btns">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    @if ($previousBlog)
                                        <a href="{{ route('blogs.show', $previousBlog->id) }}"
                                            class="blog__details__btns__item">
                                            <p><span class="arrow_left"></span></p>
                                            <h5>{{ $previousBlog->title }}</h5> <!-- Tên của bài viết trước -->
                                        </a>
                                    @else
                                        <p>Không có bài viết trước.</p>
                                    @endif
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    @if ($nextBlog)
                                        <a href="{{ route('blogs.show', $nextBlog->id) }}"
                                            class="blog__details__btns__item blog__details__btns__item--next">
                                            <p> <span class="arrow_right"></span></p>
                                            <h5>{{ $nextBlog->title }}</h5> <!-- Tên của bài viết tiếp theo -->
                                        </a>
                                    @else
                                        <p>Không có bài viết tiếp theo.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="blog__details__option">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="blog__details__author">
                                        <div class="blog__details__author__pic">
                                            <img src="/theme/client/img/blog/details/blog-author.jpg" alt="">
                                        </div>
                                        <div class="blog__details__author__text">
                                            <h5>Aiden Blair</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="blog__details__tags">
                                        <a href="#">#Fashion</a>
                                        <a href="#">#Trending</a>
                                        <a href="#">#2020</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="blog__details__comment">
                            <h4>Leave A Comment</h4>
                            <form action="#">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <input type="text" placeholder="Name">
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <input type="text" placeholder="Email">
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <input type="text" placeholder="Phone">
                                    </div>
                                    <div class="col-lg-12 text-center">
                                        <textarea placeholder="Comment"></textarea>
                                        <button type="submit" class="site-btn">Post Comment</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Section End -->
@endsection
