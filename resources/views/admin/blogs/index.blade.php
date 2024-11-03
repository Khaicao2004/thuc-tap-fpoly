@extends('admin.layouts.master')

@section('title')
    Danh sách bài viết
@endsection

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0"> Danh sách Users</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Danh sách bài viết</a></li>
                            <li class="breadcrumb-item active">Danh sách</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="card" id="diseaseList">
                    <div class="card-header border-bottom-dashed">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0">Danh sách bài viết</h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div class="d-flex flex-wrap align-items-start gap-2">
                                    <a href="{{ route('admin.blogs.create') }}" type="button"
                                        class="btn btn-success add-btn">
                                        <i class="ri-add-line align-bottom me-1"></i> Thêm
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="mb-4 me-3">
                                <label for="minDate">Ngày tạo từ:</label>
                                <input type="date" id="minDate" class="form-control">
                            </div>
                            <div class="mb-4 ms-3">
                                <label for="maxDate">Ngày tạo đến:</label>
                                <input type="date" id="maxDate" class="form-control">
                            </div>
                        </div>
                        <!-- Lọc theo ngày -->
                        <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>NAME</th>
                                    <th>ẢNH</th>
                                    <th>CREATED AT</th>
                                    <th>UPDATED AT</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>
                                            {{ $item->id }}
                                        </td>
                                        <td>
                                            {{ $item->name }}
                                        </td>
                                        <td>
                                            @php
                                                $url = $item->image;
                                                if (!Str::contains($url, 'http')) {
                                                    $url = Storage::url($url);
                                                }
                                            @endphp
                                            <a data-fancybox="gallery" data-src="{{ $url }}"
                                                data-caption="Ảnh bài viết: {{ $item->name }}">
                                                <img src="{{ $url }}" alt="Ảnh bài viết" width="100px"
                                                    height="100">
                                            </a>
                                        </td>
                                        <td>
                                            {{ $item->created_at }}
                                        </td>
                                        <td>
                                            {{ $item->updated_at }}
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <a class="btn btn-info"
                                                    href="{{ route('admin.blogs.show', $item->id) }}">Xem</a>
                                                <a class="btn btn-warning ms-2"
                                                    href="{{ route('admin.blogs.edit', $item->id) }}">Sửa</a>
                                                <form action="{{ route('admin.blogs.destroy', $item->id) }}" method="POST"
                                                    class="ms-2">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button class="btn btn-danger "
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa ko')"
                                                        type="submit">Delete</button>
                                                </form>
                                            </div>
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

    </div>
    <!-- container-fluid -->
@endsection

@section('style-libs')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
@endsection

@section('script-libs')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.6.0/jspdf.umd.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/l10n/de.umd.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                return idx !== 5;
                            }
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                return idx !== 5;
                            }
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                return idx !== 5;
                            }
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                return idx !== 5;
                            }
                        }
                    },
                    {
                        text: 'png',
                        action: function(e, dt, node, config) {
                            html2canvas(document.querySelector('#example')).then(canvas => {
                                var link = document.createElement('a');
                                link.href = canvas.toDataURL('image/png');
                                link.download = 'table-image.png';
                                link.click();
                            });
                        }
                    },
                    'print'
                ],
                order: [
                    [0, 'desc']
                ]
            });

            // Xóa các bộ lọc cũ và áp dụng bộ lọc mới
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var minDate = $('#minDate').val();
                    var maxDate = $('#maxDate').val();

                    // Convert to Date objects for comparison
                    var minDateObj = minDate ? new Date(minDate + 'T00:00:00') : null;
                    var maxDateObj = maxDate ? new Date(maxDate + 'T23:59:59') : null;

                    var createdAt = data[4] || ''; // Cột thời gian tạo
                    var createdAtDate = new Date(createdAt);

                    if (
                        (minDateObj === null && maxDateObj === null) ||
                        (minDateObj === null && createdAtDate <= maxDateObj) ||
                        (minDateObj <= createdAtDate && maxDateObj === null) ||
                        (minDateObj <= createdAtDate && createdAtDate <= maxDateObj)
                    ) {
                        return true;
                    }
                    return false;
                }
            );

            $('#minDate, #maxDate').on('change', function() {
                table.draw();
            });

            // Tạo filter tìm kiếm văn bản
            $('#searchText').on('keyup', function() {
                table.search(this.value).draw();
            });
        });
    </script>


    <script>
        Fancybox.bind('[data-fancybox]', {
            l10n: Fancybox.l10n.de
        });
    </script>
@endsection
