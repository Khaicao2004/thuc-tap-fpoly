@extends('admin.layouts.master')

@section('title')
    Sửa tag {{ $tag->name }}
@endsection

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">Đã có lỗi nhập liệu. Vui lòng kiểm tra lại!</div>
    @endif

    <form action="{{ route('admin.tags.update', $tag) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">
                            Sửa tag: {{ $tag->name }}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row gy-4">

                                <div class="col-lg-12">
                                    <label for="name">Tên tag</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror" placeholder="Nhập tên tag"
                                        value="{{ $tag->name }}">
                                    @error('name')
                                        <span class="d-block text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">Sửa</button>
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
