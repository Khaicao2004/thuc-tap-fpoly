@extends('admin.layouts.master')

@section('title')
    Chi tiết tag: {{ $tag->name }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Chi tiết tag</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">tag</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Chi tiết
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Chi tiết tag: {{ $tag->name }}</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <div class="live-preview">
                            <div class="row gy-4">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên tag</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $tag->name) }}" disabled>
                                </div>
                                <a href="{{ route('admin.tags.index') }}" class="btn btn-primary mt-3">Quay lại danh sách</a>
                            </div>
                        </div>
                        <!--end row-->
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
@endsection
