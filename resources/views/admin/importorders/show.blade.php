@extends('admin.layouts.master')

@section('title', 'Chi tiết đơn hàng nhập kho')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Chi tiết đơn hàng sản phẩm</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Sản phẩm</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.importorder.index') }}">Danh sách Sản phẩm</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Chi tiết
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Thông tin Sản phẩm</h4>
        </div>
        <div class="card-body">

            <div class="mb-3">
                <label for="user_id" class="form-label"><strong>Người dùng:</strong></label>
                <input type="user_id" name="user_id" id="user_id" class="form-control"
                    value="{{ $importOrder->user->name }}" readonly>
            </div>

            <div class="mb-3">
                <label for="ware_house_id" class="form-label"><strong>Kho:</strong></label>
                <input type="ware_house_id" name="ware_house_id" id="ware_house_id" class="form-control"
                    value="{{ $importOrder->storage->name }}" readonly>
            </div>

            <div class="mb-3">
                <label for="supplier_id" class="form-label"><strong>Nhà cung cấp:</strong></label>
                <input type="supplier_id" name="supplier_id" id="supplier_id" class="form-control"
                    value="{{ $importOrder->supplier->name }}" readonly>
            </div>

            <div class="mb-3">
                <label for="total" class="form-label"><strong>Tổng:</strong></label>
                <input type="total" name="total" id="total" class="form-control"
                    value="{{ number_format($importOrder->total, 2) }}" readonly>
            </div>

            <div class="mb-3">
                <label for="price_paid" class="form-label"><strong>Số tiền đã trả:</strong></label>
                <input type="price_paid" name="price_paid" id="price_paid" class="form-control"
                    value="{{ number_format($importOrder->price_paid, 2) }}" readonly>
            </div>

            <div class="mb-3">
                <label for="still_in_debt" class="form-label"><strong>Còn nợ:</strong></label>
                <input type="still_in_debt" name="still_in_debt" id="still_in_debt" class="form-control"
                    value="{{ number_format($importOrder->still_in_debt, 2) }}" readonly>
            </div>

            <div class="mb-3">
                <label for="date_added" class="form-label"><strong>Ngày thêm:</strong></label>
                <input type="date_added" name="date_added" id="date_added" class="form-control"
                    value="{{ $importOrder->date_added }}" readonly>
            </div>

            <div class="mb-3">
                <label for="note" class="form-label"><strong>Ghi chú:</strong></label>
                <input type="note" name="note" id="note" class="form-control" value="{{ $importOrder->note }}"
                    readonly>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label"><strong>Trạng thái:</strong></label>
                <input type="status" name="status" id="statu" class="form-control" value="{{ $importOrder->status }}"
                    readonly>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h4 class="card-title">Chi tiết đơn hàng</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Size</th>
                        <th>Màu sắc</th>
                        <th>Giá nhập</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                        <th>Ngày nhập</th>
                        <th>Ngày hết hạn</th>
                        <th>Ảnh chính</th>
                        <th>Ảnh</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($importOrder->details as $detail)
                        @foreach ($detail->product->variants as $variant)
                            <tr>
                                <!-- Hiển thị thông tin sản phẩm -->
                                <td>{{ $detail->product->name }}</td>
                                <td>{{ $variant->size ? $variant->size->name : 'N/A' }}</td>
                                <td>{{ $variant->color ? $variant->color->name : 'N/A' }}</td>
                                <td>{{ number_format($variant->price, 2) }}</td>
                                <td>{{ $variant->quantity }}</td>
                                <td>{{ number_format($variant->price * $variant->quantity, 2) }}</td>
                                <td>{{ $detail->date_added }}</td>
                                <td>{{ $detail->expiration_date }}</td>
    
                                <!-- Hiển thị ảnh chính của biến thể -->
                                <td>
                                    @if($variant->image)
                                        <img src="{{ asset('storage/' . $variant->image) }}" alt="Ảnh chính" style="width: 50px; height: 50px;">
                                    @else
                                        Không có ảnh
                                    @endif
                                </td>
    
                                <!-- Hiển thị nhiều ảnh nhỏ nếu có (giả sử ảnh nhỏ được lưu trong trường images) -->
                                <td>
                                    @if(!empty($variant->images))
                                        @foreach($variant->images as $image)
                                            <img src="{{ asset('storage/' . $image) }}" alt="Ảnh nhỏ" style="width: 30px; height: 30px; margin-right: 5px;">
                                        @endforeach
                                    @else
                                        Không có ảnh 
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="text-end m-3">
        <a href="{{ route('admin.importorders.index') }}" class="btn btn-primary">Quay lại</a>
    </div>
@endsection
