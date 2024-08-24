@extends('admin.layouts.master')

@section('title')
    Thêm mới tag
@endsection

@section('content')


    @if ($errors->any())
        <div class="alert alert-danger">Đã có lỗi nhập liệu. Vui lòng kiểm tra lại!</div>
    @endif

    <form action="{{ route('admin.tags.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">
                            Thêm mới tag
                        </h4>
                    </div>
                    <!-- end card header -->
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row gy-4">

                                <div class="col-lg-12">
                                    <label for="name">Tên tag</label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Nhập tên tag">
                                    @error('name')
                                        <span class="d-block text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                                </div>

                            </div>
                            <!--end row-->
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
    </form>
@endsection
