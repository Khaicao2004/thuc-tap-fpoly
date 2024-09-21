@extends('admin.layouts.master')

@section('title')
    Cập nhật mã giảm giá: {{ $coupon->name }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Cập nhật mã giảm giá: {{ $coupon->name }}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Mã giảm giá</a></li>
                        <li class="breadcrumb-item active">Cập nhật</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">
                            Thông tin
                        </h4>
                    </div>
                    <!-- end card header -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row gy-4">

                                <div class="col-6">
                                    <div>
                                        <label for="name" class="form-label">Tên mã</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $coupon->name }}" />
                                    </div>

                                    <div class="mt-3">
                                        <label for="start_date" class="form-label">Ngày bắt đầu</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date"
                                            value="{{ $coupon->start_date }}">
                                    </div>

                                    <div class="mt-3">
                                        <label for="min_order_value" class="form-label">Giá trị tối thiểu của đơn hàng (Số
                                            tiền)</label>
                                        <input type="number" class="form-control" name="min_order_value"
                                            id="min_order_value" value="{{ $coupon->min_order_value }}">
                                    </div>
                                    <div class="mt-3">
                                        <label for="discount_type" class="form-label">Kiểu giảm giá</label>
                                        <select name="discount_type" id="discount_type" class="form-control">
                                            @if ($coupon->discount_type == 'fixed_product')

                                            <option value="fixed_product" selected>Giảm giá theo sản phẩm cố định</option>
                                            <option value="fixed_cart">Giảm giá theo giỏ hàng cố định</option>
                                            <option value="percent_product">Giảm giá theo phần trăm sản phẩm</option>
                                            <option value="percent_cart">Giảm giá theo phần trăm giá trị giỏ hàng</option>

                                            @elseif ($coupon->discount_type == 'fixed_cart')

                                            <option value="fixed_product">Giảm giá theo sản phẩm cố định</option>
                                            <option value="fixed_cart" selected>Giảm giá theo giỏ hàng cố định</option>
                                            <option value="percent_product">Giảm giá theo phần trăm sản phẩm</option>
                                            <option value="percent_cart">Giảm giá theo phần trăm giá trị giỏ hàng</option>

                                            @elseif ($coupon->discount_type == 'percent_product')

                                            <option value="fixed_product">Giảm giá theo sản phẩm cố định</option>
                                            <option value="fixed_cart">Giảm giá theo giỏ hàng cố định</option>
                                            <option value="percent_product" selected>Giảm giá theo phần trăm sản phẩm</option>
                                            <option value="percent_cart">Giảm giá theo phần trăm giá trị giỏ hàng</option>

                                            @else
                                            <option value="fixed_product">Giảm giá theo sản phẩm cố định</option>
                                            <option value="fixed_cart">Giảm giá theo giỏ hàng cố định</option>
                                            <option value="percent_product">Giảm giá theo phần trăm sản phẩm</option>
                                            <option value="percent_cart" selected>Giảm giá theo phần trăm giá trị giỏ hàng</option>
                                            @endif
                                           
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div>
                                        <label for="discount_value" class="form-label">Giá trị</label>
                                        <input type="number" class="form-control" name="discount_value" id="discount_value"
                                            value="{{ $coupon->discount_value }}">
                                    </div>

                                    <div class="mt-3">
                                        <label for="end_date" class="form-label">Ngày kết thúc</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date"
                                            value="{{ $coupon->end_date }}">
                                    </div>

                                    <div class="mt-3">
                                        <label for="usage_limit" class="form-label">Số lượng mã</label>
                                        <input type="number" class="form-control" id="usage_limit" name="usage_limit"
                                            value="{{ $coupon->usage_limit }}" />
                                    </div>
                                    <div class="form-check form-switch form-switch-primary mt-5">
                                        <input class="form-check-input" type="checkbox" role="switch" name="is_active"
                                            id="is_active" value="1" @if ($coupon->is_active == true) checked @endif>
                                        <label class="form-check-label" for="is_active">Is Active</label>
                                    </div>
                                </div>
                            </div>
                            <!--end row-->
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
    </form>
@endsection

@section('script-libs')
    <script src="{{ asset('theme/admin/assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
@endsection

@section('scripts')
    <script>
        ClassicEditor.create(document.querySelector('#content'))
            .catch(error => {
                console.error(error);
            });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection

@section('style-libs')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
@endsection
