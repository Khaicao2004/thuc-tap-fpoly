@extends('admin.layouts.master')

@section('title')
    Thêm mới sản phẩm
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới mã giảm giá</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Sản phẩm</a></li>
                        <li class="breadcrumb-item active">Thêm mới</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.coupons.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
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
                                        <input type="text" class="form-control" id="name" name="name" />
                                    </div>

                                    <div class="mt-3">
                                        <label for="start_date" class="form-label">Ngày bắt đầu</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date">
                                    </div>

                                    <div class="mt-3">
                                        <label for="min_order_value" class="form-label">Giá trị tối thiểu của đơn hàng (Số
                                            tiền)</label>
                                        <input type="number" class="form-control" name="min_order_value"
                                            id="min_order_value">
                                    </div>
                                    <div class="mt-3">
                                        <label for="discount_type" class="form-label">Kiểu giảm giá</label>
                                        <select name="discount_type" id="discount_type" class="form-control">
                                            <option value="">Chọn loại giảm giá</option>
                                            <option value="fixed_product">Giảm giá theo sản phẩm cố định</option>
                                            <option value="fixed_cart">Giảm giá theo giỏ hàng cố định</option>
                                            <option value="percent_product">Giảm giá theo phần trăm sản phẩm</option>
                                            <option value="percent_cart">Giảm giá theo phần trăm giá trị giỏ hàng</option>
                                        </select>
                                    </div>
                                    <div class="mt-3">
                                        <button type="button" class="btn btn-primary mb-3" id="select-products-btn">Chọn sản
                                            phẩm áp dụng</button>
                                        <div id="product-selection" style="display: none;">
                                            <label for="products" class="form-label">Chọn sản phẩm áp dụng:</label>
                                            <select id="products" class="form-select" id="products" name="products[]" multiple>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                  
                                </div>

                                <div class="col-6">
                                    <div>
                                        <label for="discount_value" class="form-label">Giá trị</label>
                                        <input type="number" class="form-control" name="discount_value"
                                            id="discount_value">
                                    </div>

                                    <div class="mt-3">
                                        <label for="end_date" class="form-label">Ngày kết thúc</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date">
                                    </div>

                                    <div class="mt-3">
                                        <label for="usage_limit" class="form-label">Giới hạn số lần sử dụng:</label>
                                        <input type="number" class="form-control" id="usage_limit" name="usage_limit"
                                            value="1" />
                                    </div>

                                    <div class="mt-3">
                                        <label for="max_usage_per_user" class="form-label">Số lần tối đa mã có thể sử dụng
                                            bởi mỗi người dùng:</label>
                                        <input type="number" id="max_usage_per_user" class="form-control"
                                            name="max_usage_per_user" value="1">
                                    </div>
                                    <div class="form-check form-switch form-switch-primary mt-5">
                                        <input class="form-check-input" type="checkbox" role="switch" name="is_active"
                                            id="is_active" value="1" checked>
                                        <label class="form-check-label" for="is_active">Is Active</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="description">Mô tả</label>
                                    <textarea name="description" id="description" class="form-control"></textarea>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $("#products, #discount_type").select2({
                allowClear: true,
                dropdownAutoWidth: true
            });
            $('.js-example-basic-single').select2({
                dropdownAutoWidth: true
            });
        });
        document.getElementById('select-products-btn').onclick = function() {
            var productSelection = document.getElementById('product-selection');
            productSelection.style.display = productSelection.style.display === 'none' ? 'block' : 'none';
        }
    </script>
@endsection

@section('style-libs')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
@endsection
