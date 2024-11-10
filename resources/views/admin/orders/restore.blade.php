<!-- index.blade.php -->

@extends('admin.layouts.trash')

@section('title')
    Danh sách danh mục đã xóa
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card vh-100">


                <div class="card-body">
                    <div class="tab-content text-muted">
                        <div class="tab-pane active" id="categories" role="tabpanel">
                            <div class="profile-timeline">
                                <div class="accordion accordion-flush" id="categoriesExample">
                                    <!-- start page title -->
                                    <h4>Danh mục đã xóa</h4>
                                    <!-- end page title -->
                                    <div class="table-responsive">
                                        <table class="table align-middle mb-0">



                                            @if (session('success'))
                                                <div class="alert alert-success mb-3">
                                                    {{ session('success') }}
                                                </div>
                                            @endif

                                            <thead class="table-light">
                                                <form action="{{ route('admin.restore.orders') }}" method="POST">
                                                    @csrf
                                                    <table id="example"
                                                        class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                                        style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th><input type="checkbox" id="select-all"></th>
                                                                <th>ID</th>
                                                                <th>User name</th>
                                                                <th>User email</th>
                                                                <th>User phone</th>
                                                                <th>User address</th>
                                                                <th>Status order</th>
                                                                <th>Status payment</th>
                                                                <th>User note</th>
                                                                <th>Total price</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($data as $suppliers)
                                                                <tr>
                                                                    <td>
                                                                        <input type="checkbox" name="ids[]"
                                                                            value="{{ $suppliers->id }}">
                                                                    </td>
                                                                    <td>{{ $item->id }}</td>
                                                                    <td>{{ $item->user_name }}</td>
                                                                    <td>{{ $item->user_email }}</td>
                                                                    <td>{{ $item->user_phone }}</td>
                                                                    <td>{{ $item->user_address }}</td>
                                                                    <td>
                                                                        @php
                                                                            if ($item->status_order == 'pending') {
                                                                                echo '<span class="badge bg-warning">Chờ xác nhận</span>';
                                                                            } elseif (
                                                                                $item->status_order == 'confirmed'
                                                                            ) {
                                                                                echo '<span class="badge bg-primary">Đã xác nhận</span>';
                                                                            } elseif (
                                                                                $item->status_order == 'preparing_goods'
                                                                            ) {
                                                                                echo '<span class="badge bg-dark">Đang chuẩn bị hàng</span>';
                                                                            } elseif (
                                                                                $item->status_order == 'shipping'
                                                                            ) {
                                                                                echo '<span class="badge bg-secondary">Đã vận chuyển</span>';
                                                                            } elseif (
                                                                                $item->status_order == 'delivered'
                                                                            ) {
                                                                                echo '<span class="badge bg-success">Đã giao hàng</span>';
                                                                            } elseif (
                                                                                $item->status_order == 'canceled'
                                                                            ) {
                                                                                echo '<span class="badge bg-danger">Đơn hàng bị hủy</span>';
                                                                            }
                                                                        @endphp
                                                                    </td>
                                                                    <td>
                                                                        @php
                                                                            if ($item->status_payment == 'unpaid') {
                                                                                echo '<span class="badge bg-danger">Chưa thanh toán</span>';
                                                                            } elseif ($item->status_payment == 'paid') {
                                                                                echo '<span class="badge bg-success">Đã thanh toán</span>';
                                                                            }
                                                                        @endphp
                                                                    </td>
                                                                    <td>{{ $item->user_note }}</td>
                                                                    <td>{{ $item->total_price }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    <button type="submit" class="btn btn-primary">Khôi phục</button>
                                                </form>
                                            </thead>
                                        </table>
                                        <!-- end table -->
                                    </div>
                                </div>
                                <!--end accordion-->
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->

            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->
    <!-- container-fluid -->
@endsection

@section('css')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <!-- DataTables Responsive CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
@endsection

@section('script-libs')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
@endsection

@section('js')
    {{-- <script>
        new DataTable("#example", {
            order: [
                [0, 'desc']
            ]
        });
    </script> --}}
    <script>
        document.getElementById('select-all').addEventListener('click', function() {
            var checkboxes = document.querySelectorAll('input[name="ids[]"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = this.checked;
            }, this);
        });
    </script>
@endsection
