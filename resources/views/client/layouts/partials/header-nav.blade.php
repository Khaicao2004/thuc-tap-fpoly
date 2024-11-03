<div class="container">
    <div class="row justify-content-between align-items-center">
        <div class="col-lg-3 col-md-3">
            <div class="header__logo">
                <a href="{{ route('home') }}"><img src="/theme/client/img/logo.png" alt=""></a>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <nav class="header__menu mobile-menu">
                <ul>
                    <li class="active"><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('shop') }}">Shop</a></li>
                    <li><a href="#">Pages</a>
                        <ul class="dropdown">
                            <li><a href="{{ route('about') }}">About Us</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('blogs.list') }}">Blog</a></li>
                    <li><a href="{{ route('contact') }}">Contacts</a></li>
                </ul>
            </nav>
        </div>

        <div class="col-lg-3 col-md-3">
            <div class="header__nav__option d-flex align-items-center justify-content-between">
                <button class="search-switch btn btn-secondery"><img src="/theme/client/img/icon/search.png"
                        alt=""></button>
                <a href="{{ route('cart.list') }}"><img src="/theme/client/img/icon/cart.png" alt="">
                    <span>{{ count(session('cart', [])) }}</span></a>
                <div class="dropdown ms-sm-3 header-item topbar-user" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <button type="button" class="btn">
                        <span class="d-flex align-items-center">
                            <img src="/theme/client/img/icon/user.svg" alt="" style="width: 17px; height: 17px">
                            @if (Auth::check())
                                <span class="text-start ms-2">{{ Auth::user()->name }}</span>
                            @endif
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        @if (Auth::check())
                            <h6 class="dropdown-header">Welcome {{ Auth::user()->name }}!</h6>
                            {{-- <a class="dropdown-item" href="{{ route('admin.users.edit', Auth::user()->id) }}">
                                <i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i>
                                <span class="align-middle">Profile</span>
                            </a> --}}
                            <button class="dropdown-item">
                                <a href="{{ route('orders.list') }}" class="text-dark">Đơn hàng</a>
                            </button>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        @else
                            <h6 class="dropdown-header">Welcome!</h6>
                            <a class="dropdown-item btn" href="{{ route('login') }}">
                                Login
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <style>
                .dropdown-menu {
                    display: none;
                    /* Ẩn menu theo mặc định */
                }

                .topbar-user:hover .dropdown-menu {
                    display: block;
                    /* Hiển thị menu khi hover */
                }
            </style>
        </div>
    </div>
    <div class="canvas__open"><i class="fa fa-bars"></i></div>
</div>
<div class="item-nav">
    <div class="container">
        <nav class="header__menu mobile-menu">
            <ul class="ul-nav">
                <li class="active"><a href="{{ route('home') }}"><span class="icon">
                    <svg style="margin-bottom: 4px" width="20" height="15" viewBox="0 0 19 15"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M16.2881 8.63991V14.2518C16.2881 14.4544 16.2135 14.6298 16.0642 14.7779C15.915 14.926 15.7382 15 15.5339 15H11.0085V10.5105H7.99152V15H3.46609C3.26182 15 3.08504 14.926 2.93577 14.7779C2.78649 14.6298 2.71185 14.4544 2.71185 14.2518V8.63991C2.71185 8.63211 2.71382 8.62042 2.71775 8.60483C2.72167 8.58924 2.72364 8.57755 2.72364 8.56976L9.5 3.02806L16.2764 8.56976C16.2842 8.58535 16.2881 8.60873 16.2881 8.63991ZM18.9162 7.8332L18.1855 8.69836C18.1227 8.76851 18.0402 8.81138 17.938 8.82697H17.9027C17.8006 8.82697 17.7181 8.79969 17.6552 8.74513L9.5 1.99922L1.3448 8.74513C1.25052 8.80748 1.15624 8.83476 1.06196 8.82697C0.959821 8.81138 0.877326 8.76851 0.814473 8.69836L0.0838043 7.8332C0.0209511 7.75526 -0.00654721 7.66368 0.00130944 7.55846C0.00916609 7.45323 0.0523777 7.36945 0.130944 7.30709L8.60434 0.303975C8.85575 0.101325 9.15431 0 9.5 0C9.84569 0 10.1442 0.101325 10.3957 0.303975L13.2712 2.68901V0.409197C13.2712 0.300078 13.3065 0.210444 13.3773 0.140296C13.448 0.0701481 13.5383 0.035074 13.6483 0.035074H15.911C16.021 0.035074 16.1114 0.0701481 16.1821 0.140296C16.2528 0.210444 16.2881 0.300078 16.2881 0.409197V5.17927L18.8691 7.30709C18.9476 7.36945 18.9908 7.45323 18.9987 7.55846C19.0065 7.66368 18.979 7.75526 18.9162 7.8332Z"
                            fill="black" />
                    </svg>
                </span>Trang chủ</a></li>
                @foreach ($catalogue->take(8) as $category)
                    <li class="new-dropdown"><a href="{{ route('home', ['slug' => $category->slug]) }}">{{ $category->name }}</a>
                        @if ($category->children->count())
                            <ul class="dropdown">
                                @foreach ($category->children as $child)
                                    <div class="item-dropdown">
                                        <li><a style="font-weight: bold;" href="{{ route('home', ['slug' => $child->slug]) }}">{{ $child->name }}</a>
                                            @if ($child->children->count())
                                                <div class="sub-dropdown">
                                                    <ul>
                                                        @foreach ($child->children as $subChild)
                                                            <li><a href="{{ route('home', ['slug' => $subChild->slug]) }}">{{ $subChild->name }}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </li>
                                    </div>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
                <li class="active"><a href="#"><span class="icon"> </span>Tin tức</a></li>
                <li class="active"><a href="#"><span class="icon"> </span>Giới thiệu</a></li>
                <li class="active"><a href="#"><span class="icon"> </span>Liên hệ</a></li>
            </ul>
        </nav>
    </div>
</div>
