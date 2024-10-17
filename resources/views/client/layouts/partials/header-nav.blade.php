<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-3">
            <div class="header__logo">
                <a href="{{ route('home') }}"><img src="/theme/client/img/logo.png" alt=""></a>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <nav class="header__menu mobile-menu">
                <ul>
                    <li class="active"><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="">Shop</a></li>
                    <li><a href="#">Pages</a>
                        <ul class="dropdown">
                            <li><a href="{{ route('about') }}">About Us</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('blog') }}">Blog</a></li>
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
                    <div class="price">{{ number_format($totalAmount, 0, ',', '.') }} VNĐ</div>

                <div class="dropdown ms-sm-3 header-item topbar-user"  id="page-header-user-dropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
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
                    display: none; /* Ẩn menu theo mặc định */
                }
                .topbar-user:hover .dropdown-menu {
                    display: block; /* Hiển thị menu khi hover */
                }
            </style>
        </div>
    </div>
    <div class="canvas__open"><i class="fa fa-bars"></i></div>
</div>
