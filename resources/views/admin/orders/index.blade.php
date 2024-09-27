@extends('admin.layouts.master')

@section('title')
    Danh sách đơn hàng
@endsection

@section('content')
  <!-- start page title -->
  <div class="row">
    <div class="col-12">
        <div
            class="page-title-box d-sm-flex align-items-center justify-content-between"
        >
            <h4 class="mb-sm-0">Danh sách đơn hàng</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);"
                            >Đơn hàng</a
                        >
                    </li>
                    <li class="breadcrumb-item active">
                        Danh sách
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title mb-0">
                    Danh sách
                </h5>
            </div>
            <div class="card-body">
                <table
                    id="example"
                    class="table table-bordered dt-responsive nowrap table-striped align-middle"
                    style="width: 100%"
                >
               <thead>
                <tr>
                    <th>ID</th>
                    <th>User name</th>
                    <th>User email</th>
                    <th>User phone</th>
                    <th>User address</th>
                    <th>Status order</th>
                    <th>Status payment</th>
                    <th>User note</th>
                    <th>Total price</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                    <th>Action</th>
                </tr>
               </thead>
                
              <tbody>
                @foreach ($data as $item)         
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->user_name}}</td>
                    <td>{{$item->user_email}}</td>
                    <td>{{$item->user_phone}}</td>
                    <td>{{$item->user_address}}</td>
                    <td>
                        @php
                            if($item->status_order == 'pending'){
                                echo '<span class="badge bg-warning">Chờ xác nhận</span>';
                            }elseif ($item->status_order == 'confirmed') {
                                echo '<span class="badge bg-primary">Đã xác nhận</span>';
                            }elseif ($item->status_order == 'preparing_goods') {
                                echo '<span class="badge bg-dark">Đang chuẩn bị hàng</span>';
                            }elseif ($item->status_order == 'shipping') {
                                echo '<span class="badge bg-secondary">Đã vận chuyển</span>';
                            }elseif ($item->status_order == 'delivered') {
                                echo '<span class="badge bg-success">Đã giao hàng</span>';
                            }elseif ($item->status_order == 'canceled') {
                                echo '<span class="badge bg-danger">Đơn hàng bị hủy</span>';
                            }
                        @endphp
                    </td>
                    <td>
                        @php
                            if($item->status_payment == 'unpaid'){
                                echo '<span class="badge bg-danger">Chưa thanh toán</span>';
                            }elseif ($item->status_payment == 'paid') {
                                echo '<span class="badge bg-success">Đã thanh toán</span>';
                            }
                        @endphp
                    </td>
                    <td>{{$item->user_note}}</td>
                    <td>{{$item->total_price}}</td>
                    <td>{{$item->created_at}}</td>
                    <td>{{$item->updated_at}}</td>
                    <td>
                        <a href="{{route('admin.orders.show', $item->id)}}" class="btn btn-primary mb-3 me-2">Xem</a>
                        <a href="{{route('admin.orders.edit', $item->id)}}" class="btn btn-warning mb-3 me-2">Sửa</a>
                    </td>
                </tr>
                @endforeach
              </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->
@endsection

@section('style-libs')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('script-libs')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<!--datatable js-->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script>
     new DataTable("#example",{
     order: [ [0, 'desc'] ]
});
</script>
@endsection