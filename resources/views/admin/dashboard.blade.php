@extends('admin.layouts.master')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <div class="h-100">
                <div class="row mb-3 pb-1">
                    <div class="col-12">
                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                            <div class="flex-grow-1">
                                <h4 class="fs-16 mb-1">Xin chào, {{ Auth::user()->name }}</h4>
                                <p class="text-muted mb-0">Đây là những thay đổi của cửa hàng trong ngày hôm nay.</p>
                            </div>
                        </div><!-- end card header -->
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->

                <div class="row">
                    <div class="col-lg-3">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Tổng doanh thu
                                            (VNĐ)
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                id="totalRevenueAllTime">0</span></h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-success-subtle rounded fs-3">
                                            <i class="bx bx-dollar-circle text-success"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->

                    <div class="col-lg-3">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Tổng đơn hàng</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                id="totalOrdersAllTime">0</span></h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-info-subtle rounded fs-3">
                                            <i class="bx bx-shopping-bag text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->

                    <div class="col-lg-3">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Khách hàng</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                id="totalMembersAllTime">0</span></h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-warning-subtle rounded fs-3">
                                            <i class="bx bx-user-circle text-warning"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                    <div class="col-lg-3">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Đơn hàng bị hủy
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                id="totalCanceledOrdersAllTime">0</span></h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-warning-subtle rounded fs-3">
                                            <i class="bx bx-block text-warning"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div> <!-- end row-->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-0 align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Revenue</h4>
                                <div>
                                    <button type="button" class="btn btn-soft-primary btn-sm btn-timeFrame"
                                        data-type="day">
                                        Day
                                    </button>
                                    <button type="button" class="btn btn-soft-primary btn-sm btn-timeFrame"
                                        data-type="week">
                                        Week
                                    </button>
                                    <button type="button" class="btn btn-soft-primary btn-sm btn-timeFrame"
                                        data-type="month">
                                        Month
                                    </button>
                                    <button type="button" class="btn btn-soft-primary btn-sm btn-timeFrame"
                                        data-type="year">
                                        Year
                                    </button>
                                </div>
                            </div><!-- end card header -->
                            <div class="card-header p-0 border-0 bg-light-subtle">
                                <div class="row g-0 text-center">
                                    <div class="col-6 col-sm-3">
                                        <div class="p-3 border border-dashed border-start-0">
                                            <h5 class="mb-1"><span id="totalOrders">0</span>
                                            </h5>
                                            <p class="text-muted mb-0">Đơn hàng</p>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-6 col-sm-3">
                                        <div class="p-3 border border-dashed border-start-0">
                                            <h5 class="mb-1"><span id="totalRevenue">0</span>
                                            </h5>
                                            <p class="text-muted mb-0">Doanh thu</p>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-6 col-sm-3">
                                        <div class="p-3 border border-dashed border-start-0">
                                            <h5 class="mb-1"><span id="totalCanceledOrders">0</span>
                                            </h5>
                                            <p class="text-muted mb-0">Đơn hàng bị hủy</p>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-6 col-sm-3">
                                        <div class="p-3 border border-dashed border-start-0 border-end-0">
                                            <h5 class="mb-1 text-success"><span id="deliverySuccessRatio">0</span>%</h5>
                                            <p class="text-muted mb-0">Tỷ lệ giao hàng thành công</p>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                            </div><!-- end card header -->

                            <div class="card-body p-0 pb-2">
                                <div class="w-100">
                                    <div id="customer_impression_charts"
                                        data-colors='["--vz-primary", "--vz-success", "--vz-danger"]' class="apex-charts"
                                        dir="ltr"></div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Top sản phẩm bán chạy</h4>
                                <div class="flex-shrink-0">
                                    <div class="dropdown card-header-dropdown">
                                        <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <span class="fw-semibold text-uppercase fs-12">Sort by:
                                            </span><span id="dropdownTitle" class="text-muted">Today<i
                                                    class="mdi mdi-chevron-down ms-1"></i></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <button type="button" class="dropdown-item selected"
                                                data-type="today">Today</button>
                                            <button type="button" class="dropdown-item"
                                                data-type="yesterday">Yesterday</button>
                                            <button type="button" class="dropdown-item" data-type="last_7_days">Last 7
                                                Days</button>
                                            <button type="button" class="dropdown-item" data-type="last_30_days">Last 30
                                                Days</button>
                                            <button type="button" class="dropdown-item" data-type="this_month">This
                                                Month</button>
                                            <button type="button" class="dropdown-item" data-type="last_month">Last
                                                Month</button>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table
                                        class="table table-hover table-centered align-middle table-nowrap text-center mb-0">
                                        <thead>
                                            <tr>
                                                <td>STT</td>
                                                <td>Ảnh sản phẩm</td>
                                                <td>Tên sản phẩm</td>
                                                <td>Giá bán</td>
                                                <td>Số lượng sản phẩm</td>
                                                <td>Tổng tiền</td>
                                            </tr>
                                        </thead>
                                        <tbody id="bestSellingProduct">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end row-->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Đơn hàng gần đây</h4>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table
                                        class="table table-borderless table-centered align-middle table-nowrap text-center mb-0">
                                        <thead class="text-muted table-light">
                                            <tr>
                                                <th scope="col">STT</th>
                                                <th scope="col">Order ID</th>
                                                <th scope="col">Khách hàng</th>
                                                <th scope="col">Sản phẩm</th>
                                                <th scope="col">Giá</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="recentOrders">

                                        </tbody><!-- end tbody -->
                                    </table><!-- end table -->
                                </div>
                            </div>
                        </div> <!-- .card-->
                    </div> <!-- .col-->
                </div> <!-- end row-->

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card card-height-100">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Thông kê danh mục sản phẩm</h4>
                                <div class="flex-shrink-0">
                                    <div class="dropdown card-header-dropdown">
                                        <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <span class="text-muted">Báo cáo<i
                                                    class="mdi mdi-chevron-down ms-1"></i></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="{{ route('admin.catalogues.index') }}">Xem
                                                chi tiết</a>
                                            <a class="dropdown-item" href="#">Tải xuống</a>
                                            <a class="dropdown-item" href="#">Export</a>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div id="store-visits-source"></div>
                                <div class="row text-center mt-3" id="category-legend"></div>
                                <!-- Nơi hiển thị danh mục -->
                            </div>
                        </div> <!-- .card-->
                    </div> <!-- .col-->

                   
                    <div class="col-xl-6">
                        <!-- card -->
                        <div class="card card-height-100">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Bản đồ nhà cung cấp</h4>
                                <div class="flex-shrink-0">
                                    <button type="button" class="btn btn-soft-primary btn-sm">
                                        Xuất báo cáo 
                                    </button>
                                </div>
                            </div><!-- end card header -->

                            <!-- card body -->
                            <div class="card-body">

                                <div id="sales-by-locations" data-colors='["--vz-light", "--vz-success", "--vz-primary"]' style="height: 269px" dir="ltr"></div>

                                <div class="px-2 py-2 mt-1" id="dashboard-suppliers">
                                    <!-- suppliers -->
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                </div> <!-- end row-->

            </div> <!-- end .h-100-->

        </div> <!-- end col -->

    </div>
@endsection

@section('scripts')
    <script src="{{ asset('library/jquery.js') }}"></script>
    <script src="{{ asset('library/dashboard.js') }}"></script>
    <!-- apexcharts -->
    <script src="{{ asset('theme/admin/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Vector map-->
    <script src="{{ asset('theme/admin/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

    <!--Swiper slider js-->
    <script src="{{ asset('theme/admin/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Dashboard init -->
    <script src="{{ asset('theme/admin/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>
@endsection

@section('styles')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('library/dashboard-supplier.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Gửi yêu cầu AJAX để lấy dữ liệu danh mục thuốc
            $.ajax({
                url: "{{ route('dashboard-categories') }}", // Đường dẫn đến route
                method: "GET",
                success: function(data) {
                    // Cấu hình ApexCharts
                    const options = {
                        chart: {
                            type: 'donut',
                            height: 230, // Chiều cao biểu đồ
                        },
                        series: data.map(item => item.count), // Lấy số lượng thuốc
                        labels: data.map(item => item.name), // Lấy tên danh mục
                        colors: ['#5A8DEE', '#f46a6a', '#34c38f', '#f7b84b', '#50a5f1'],
                        legend: {
                            show: false // Tắt legend mặc định của ApexCharts
                        },
                    };

                    const chart = new ApexCharts(document.querySelector("#store-visits-source"),
                        options);
                    chart.render();

                    // Tạo phần legend tùy chỉnh và hiển thị 4 danh mục trên một hàng
                    let legendHTML = '<div class="row justify-content-center">';
                    data.forEach((item, index) => {
                        // Chia đều 4 mục trên 1 hàng
                        if (index % 4 === 0 && index !== 0) {
                            legendHTML += '</div><div class="row justify-content-center">';
                        }
                        legendHTML += `
                        <div class="col-3 text-center legend-item" data-index="${index}" style="cursor: pointer; font-size: 8px;">
                            <span style="color: ${options.colors[index]}; display: inline-block; width: 10px; height: 10px; border-radius: 50%; background-color: ${options.colors[index]};"></span>
                            ${item.name} <!-- Chỉ hiển thị tên danh mục -->
                        </div>
                    `;
                    });
                    legendHTML += '</div>';

                    // Chèn vào phần tử HTML #category-legend
                    $('#category-legend').html(legendHTML);

                    // Thêm sự kiện mouseover và mouseleave cho các mục trong legend
                    $('.legend-item').on('mouseover', function() {
                        const index = $(this).data('index');
                        chart.toggleSeries(chart.w.globals.seriesNames[index]);
                    }).on('mouseleave', function() {
                        const index = $(this).data('index');
                        chart.toggleSeries(chart.w.globals.seriesNames[index]);
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Có lỗi xảy ra khi lấy dữ liệu:", textStatus, errorThrown);
                }
            });
        });
    </script>

    <link rel="stylesheet" href="{{ asset('/library/style.css') }}">
    <!-- jsvectormap css -->
    <link href="{{ asset('theme/admin/assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!--Swiper slider css-->
    <link href="{{ asset('theme/admin/assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
