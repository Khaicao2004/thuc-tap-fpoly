@extends('admin.layouts.master')

@section('title')
    Chi tiết User
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Chi tiết bài viết: {{ $blog->name }}</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <div class="row gy-4">
                            <div class="col-12">
                                <div>
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $blog->name }}" disabled>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label for="image" class="form-label">Image</label>
                                <img src="{{ Storage::url($blog->image) }}" alt="{{ $blog->name }}" width="100px"
                                    height="100px">
                            </div>
                            <!--end col-->
                            <div class="col-12">
                                <div class="mt-3">
                                    <label class="form-label" for="content">Content</label>
                                    <textarea class="form-control" id="content" name="content" disabled>{{ $blog->content }}</textarea>
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
        ClassicEditor.create(document.querySelector('#content'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
