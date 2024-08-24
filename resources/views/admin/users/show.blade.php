@extends('admin.layouts.master')

@section('title')
Chi tiết User
@endsection

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Chi tiết User</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">User</a></li>
                        <li class="breadcrumb-item active">Chi tiết User</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="card">
        <div class="card-body">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="form-group mb-3">
                            <label for="name">Full Name:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $user->name }}" disabled>
                        </div>

                        <div class="form-group mb-3">
                            <label for="name">Email:</label>
                            <input type="text" class="form-control" id="email" name="email"
                                value="{{ $user->email }}" disabled>
                        </div>

                        <div class="col-12">
                            <label for="password" class="form-label">Type</label>
                            <select name="type" id="type" class="form-select" disabled>
                                <option value="admin" {{ $user->type == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="member" {{ $user->type == 'member' ? 'selected' : '' }}>Member</option>
                            </select>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->

        </div>
    </div><!-- end card body -->
</div><!-- end card -->
</div>
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