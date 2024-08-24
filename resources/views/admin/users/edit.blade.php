@extends('admin.layouts.master')

@section('title')
Cập nhật User
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Cập nhật User</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">User</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Thêm mới
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif
<form action="{{route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Thêm mới</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}">
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control " id="email" name="email" value="{{ old('email', $user->email) }}">
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control " id="password" name="password" autocomplete="new-password" value="{{$user->password}} " disabled>
                        @error('password')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="password" class="form-label">Type</label>
                        <select name="type" id="type" class="form-select">
                            <option value="admin" {{ $user->type == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="member" {{ $user->type == 'member' ? 'selected' : '' }}>Member</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div><!-- end card header -->
            </div>
        </div>
        <!--end col-->
    </div>
</form>

@endsection

@section('style-libs')
<!-- Plugins css -->
<link href="{{ asset('theme/admin/assets/libs/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('script-libs')
<!-- ckeditor -->
<script src="{{ asset('theme/admin/assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

<script>
    ClassicEditor.create(document.querySelector('#symptom'))
        .catch(error => {
            console.error(error);
        });

    ClassicEditor.create(document.querySelector('#treatment_direction'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection