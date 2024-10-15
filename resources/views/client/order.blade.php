@extends('client.layouts.master')

@section('title')
    Đơn hàng
@endsection

@section('content')
    <div class="container-fluid py-4">
        <h1 class="text-center mb-4">Danh Sách Đơn Hàng</h1>

        <div class="row mb-3 justify-content-center">
            <div class="col-md-6">
                <form method="GET" action="{{ route('orders.list') }}">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Tìm kiếm theo ID đơn hàng hoặc tên khách hàng" aria-label="Search" id="searchInput" name="search" value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit" style="margin-left: 10px">Tìm kiếm</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover text-center">
                <thead>
                    <tr>
                        <th style="color: #000000;">ID Đơn Hàng</th>
                        <th style="color: #000000;">Tên Khách Hàng</th>
                        <th style="color: #000000;">Ngày Đặt Hàng</th>
                        <th style="color: #000000;">Trạng Thái</th>
                        <th style="color: #000000;">Tổng Số Tiền</th>
                        <th style="color: #000000;">Hành Động</th>
                    </tr>
                </thead>
                <tbody id="orderTableBody">
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user_name }}</td>
                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                            <td>{{ $order->status_order }}</td>
                            <td>${{ number_format($order->total_price, 2) }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" onclick="toggleOrderDetails('{{ $order->id }}')">Xem Chi Tiết</button>
                                
                                @if (in_array($order->status_order, ['pending', 'confirmed', 'preparing_goods']))
                                    <button class="btn btn-sm btn-outline-danger" onclick="cancelOrder('{{ $order->id }}')">Hủy Đơn</button>
                                @endif
                            </td>
                        </tr>
                        <tr id="details-{{ $order->id }}" style="display: none;">
                            <td colspan="6">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center">
                                        <thead>
                                            <tr>
                                                <th style="color: #007bff;">Tên Sản Phẩm</th>
                                                <th style="color: #007bff;">Số Lượng</th>
                                                <th style="color: #007bff;">Giá</th>
                                                <th style="color: #007bff;">Tổng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order->orderItems as $item)
                                                <tr>
                                                    <td>{{ $item->product_name }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>${{ number_format($item->product_price_sale, 2) }}</td>
                                                    <td>${{ number_format($item->quantity * $item->product_price_sale, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                
            </table>
        </div>
    </div>

    <script>
        function toggleOrderDetails(orderId) {
            const detailsRow = document.getElementById(`details-${orderId}`);
            if (detailsRow.style.display === "none") {
                detailsRow.style.display = "table-row"; // Hiện chi tiết
            } else {
                detailsRow.style.display = "none"; // Ẩn chi tiết
            }
        }
    
        function cancelOrder(orderId) {
            if (confirm("Bạn có chắc chắn muốn hủy đơn hàng: " + orderId + "?")) {
                fetch(`/orders/cancel/${orderId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Thêm token CSRF
                    }
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.message === 'Đơn hàng đã được hủy thành công.') {
                        // Cập nhật giao diện: Ẩn hàng hoặc cập nhật trạng thái
                        location.reload(); // Tải lại trang để cập nhật danh sách
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }
    </script>
    

    <style>
        .table {
            border-radius: 0.5rem; /* Bo tròn các góc */
            overflow: hidden; /* Đảm bảo không bị tràn ra ngoài */
        }

        th {
            vertical-align: middle; /* Căn giữa theo chiều dọc */
        }
    </style>
@endsection
