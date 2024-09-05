@extends('admin.layouts.master')

@section('title')
   Cập nhật biến thể màu: {{$productcolor->name}}
@endsection

@section('content')
<form action="{{route('admin.productcolors.update',$productcolor)}}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
      <div class="col-lg-12">
          <div class="card">
                  <div class="card-header align-items-center d-flex">
                  <h4 class="card-title mb-0 flex-grow-1">Cập nhật biến thể màu: {{$productcolor->name}}</h4>
              </div><!-- end card header -->
              <div class="card-body">
                  <div class="live-preview">
                      <div class="row gy-4">
                          <div class="col-md-4">
                              <div>
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control @error('name')is-invalid @enderror" id="name" name="name"  value="{{$productcolor->name}}">
                                <div class="invalid-feedback">
                                  @error('name')
                                      {{ $message }}
                                  @enderror
                              </div>       
                          </div>
                          <div class="col-md-8">
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