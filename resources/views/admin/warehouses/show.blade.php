@extends('admin.layouts.master')

@section('title')
   Chi tiết thuộc tính: {{ $warehouse->name }}
@endsection

@section('content')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Chi tiết thuộc tính: {{ $warehouse->name }}</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row gy-4">
                                <div class="col-6">
                                    <div>
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control mb-2" id="name" name="name"
                                            value="{{  $warehouse->name }}" disabled>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div>
                                        <label for="location" class="form-label">Location</label>
                                        <input type="text" class="form-control mb-2" id="location" name="location"
                                            value="{{  $warehouse->location }}" disabled>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
@endsection
