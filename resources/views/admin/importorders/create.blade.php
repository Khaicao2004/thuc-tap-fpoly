@extends('admin.layouts.master')

@section('title')
    Nhập mới sản phẩm
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Nhập mới sản phẩm</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Sản phẩm</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Thêm mới
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('admin.importorders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Thông tin </h4>
                    </div><!-- end card header -->
                    <div class="card-body ">
                        <div class="live-preview">
                            <div class=" row mb-3 border p-3 rounded">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="user_id" class="form-label">Người nhập kho:</label>
                                        <input type="text" id="user_id" class="form-control"
                                            value="{{ Auth::user()->name }}" disabled>
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                        {{-- @error('user_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror --}}
                                    </div>

                                    <div class="mb-3">
                                        <label for="ware_house_id" class="form-label">Kho Hàng:</label>
                                        <select id="ware_house_id" name="ware_house_id" class="form-select">
                                            <option value="">Chọn kho sản phẩm</option>
                                            @foreach ($warehouses as $warehouse)
                                                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="supplier_id" class="form-label">Nhà cung cấp:</label>
                                        <select id="supplier" name="supplier_id" class="form-select">
                                            @foreach ($suppliers as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('supplier_id')
                                            <span class="d-block text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="price_paid" class="form-label">Số tiền đã trả:</label>
                                        <input type="number" id="price_paid" name="price_paid" class="form-control">
                                        @error('price_paid')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="still_in_debt" class="form-label">Còn nợ:</label>
                                        <input type="number" id="still_in_debt" name="still_in_debt" class="form-control">
                                        @error('still_in_debt')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="status" class="form-label">Trạng thái:</label>
                                        <input type="text" id="" name="status" class="form-control">
                                        @error('status')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="note" class="form-label">Ghi chú:</label>
                                        <textarea id="note" name="note" class="form-control"></textarea>
                                        @error('note')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="max-height: 500px; overflow-y: auto;">
            <div class="col-lg-12 custom-spacing" id="product_details_container">
                <!-- Card Chi tiết Sản phẩm -->
                <div class="card detail-card mb-3" data-default="true">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Chi tiết sản phẩm</h4>
                    </div>
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row gy-4">
                                <div class="col-md-4">
                                    <div class="mt-3">
                                        <label for="name" class="form-label">Tên sản phẩm</label>
                                        <input type="text" class="form-control" name="detail[0][name]" />
                                    </div>

                                    <div class="mt-3">
                                        <label for="sku" class="form-label">Mã sản phẩm</label>
                                        <input type="text" class="form-control" name="detail[0][sku]"
                                            value="{{ strtoupper(Str::random(8)) }}" />
                                    </div>

                                    <div class="mt-3">
                                        <label for="price_regular" class="form-label">Giá nhập</label>
                                        <input type="number" value="0" class="form-control"
                                            name="detail[0][price_regular]">
                                    </div>

                                    <div class="mt-3">
                                        <label for="price_sale" class="form-label">Giá bán</label>
                                        <input type="number" value="0" class="form-control" name="detail[0][price_sale]">
                                    </div>

                                    <div class="mt-3">
                                        <label for="catalogue_id" class="form-label">Danh mục sản phẩm</label>
                                        <select name="detail[0][catalogue_id]" class="form-select">
                                            @foreach ($catalogues as $id => $name)
                                                <option value="{{ $id }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mt-3">
                                        <label for="img_thumbnail" class="form-label">Ảnh sản phẩm</label>
                                        <input type="file" class="form-control" name="detail[0][img_thumbnail]" />
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="detail[is_active]"
                                                    checked>
                                                <label class="form-check-label">Is Active</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="detail[is_hot_deal]"
                                                    checked>
                                                <label class="form-check-label">Is Hot Deal</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="detail[is_good_deal]"
                                                    checked>
                                                <label class="form-check-label">Is Good Deal</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="detail[is_new]" checked>
                                                <label class="form-check-label">Is New</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="detail[is_show_home]"
                                                    checked>
                                                <label class="form-check-label">Is Show Home</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="mt-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control" name="detail[description]" rows="2"></textarea>
                                        </div>
                                        <div class="mt-3">
                                            <label for="material" class="form-label">Material</label>
                                            <textarea class="form-control" name="detail[material]" rows="2"></textarea>
                                        </div>
                                        <div class="mt-3">
                                            <label for="user_manual" class="form-label">User Manual</label>
                                            <textarea class="form-control" name="detail[user_manual]" rows="2"></textarea>
                                        </div>
                                        <div class="mt-3">
                                            <label for="content" class="form-label">Content</label>
                                            <textarea class="form-control" name="detail[content]">{{ old('content') }}</textarea>
                                            @error('content')
                                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end row-->
                        </div>
                    </div>

                    <!-- Biến thể sản phẩm của chi tiết đó -->
                    <div class="row" style="height: 500px; overflow: scroll;">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Biến thể</h4>
                                </div>
                                <div class="card-body p-4">
                                    <div class="live-preview">
                                        <div class="row gy-4">
                                            <table>
                                                <tr>
                                                    <th>Size</th>
                                                    <th>Color</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Image</th>
                                                </tr>
                                                @foreach ($sizes as $sizeID => $sizeName)
                                                    @foreach ($colors as $colorID => $colorName)
                                                        <tr>
                                                            <td>{{ $sizeName }}</td>
                                                            <td>
                                                                <div
                                                                    style="width: 50px; height: 50px; background-color: {{ $colorName }}">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="product_variants[{{ $sizeID . '-' . $colorID }}][price][]">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="product_variants[{{ $sizeID . '-' . $colorID }}][quantity][]">
                                                            </td>
                                                            <td>
                                                                <input type="file" class="form-control"
                                                                    name="product_variants[{{ $sizeID . '-' . $colorID }}][image][]">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                    </div>

                    <!-- Thư viện ảnh của chi tiết đó -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Gallery</h4>
                                </div>
                                <div class="card-body">
                                    <div class="live-preview">
                                        <div class="row gy-4" id="gallery_list">
                                            <div class="col-md-4" id="gallery_default_item">
                                                <label for="gallery_default" class="form-label">Image</label>
                                                <div class="d-flex">
                                                    <input type="file" class="form-control"
                                                        name="product_galleries[]" id="gallery_default" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tags của chi tiết đó -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Tags</h4>
                                </div>
                                <div class="card-body">
                                    <div class="live-preview">
                                        <div class="row gy-4">
                                            <div class="col-md-12">
                                                <div>
                                                    <label for="tags" class="form-label">Tag</label>
                                                    <select name="tags[]" id="tags"
                                                        class="js-example-basic-multiple" multiple="multiple">
                                                        @foreach ($tags as $id => $name)
                                                            <option value="{{ $id }}">{{ $name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
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
                </div>
                <!--end card chi tiết sản phẩm-->
            </div>

            <div class="col-lg-12">
                <button type="button" id="add-detail" class="btn btn-primary mt-3">Thêm chi tiết sản phẩm</button>
            </div>
        </div>

        <script>
            document.getElementById('add-detail').addEventListener('click', function() {
                // Clone the first detail card
                const originalDetailCard = document.querySelector('.detail-card[data-default="true"]');
                const newDetailCard = originalDetailCard.cloneNode(true);

                // Reset input values in the cloned card
                const inputs = newDetailCard.querySelectorAll('input[type="text"], input[type="number"], textarea');
                inputs.forEach(input => {
                    input.value = ''; // Reset value
                    if (input.type === 'checkbox') {
                        input.checked = true; // Reset checkbox to checked
                    }
                });

                // Remove the "data-default" attribute and add a remove button
                newDetailCard.removeAttribute('data-default');

                // Create and append the remove button
                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'btn btn-danger mt-3';
                removeButton.textContent = 'Xóa chi tiết này';
                removeButton.onclick = function() {
                    newDetailCard.remove();
                };

                newDetailCard.appendChild(removeButton);

                // Append the cloned card to the container
                document.getElementById('product_details_container').appendChild(newDetailCard);
            });
        </script>

        <div class="col-lg-12 custom-spacing ">
            <div class="card">
                <div class="text-end m-3">
                    <a href="{{ route('admin.importorders.index') }}">
                        <button type="button" class="btn btn-primary w-sm">Quay lại</button>
                    </a>
                    <button type="submit" class="btn btn-success w-sm">Nhập mới</button>
                </div>
            </div>
        </div>
    </form>

    <script src="{{ asset('js/total-calculator.js') }}"></script>
@endsection
@section('scripts')
    <script>
        ClassicEditor.create(document.querySelector('#content'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection

@section('style-libs')
    <!-- Plugins css -->
    <link href="{{ asset('theme/admin/assets/libs/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('theme/admin/assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
    {{-- select2 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#tags").select2({
                allowClear: true,
                dropdownAutoWidth: true
            });
            $('.js-example-basic-single').select2({
                dropdownAutoWidth: true
            });
        });
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
@endsection
