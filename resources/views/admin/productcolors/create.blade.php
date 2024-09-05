@extends('admin.layouts.master')

@section('title')
    Thêm mới biến thể màu
@endsection

@section('content')
<form action="{{route('admin.productcolors.store')}}" method="POST">
    @csrf
    <div class="row">
      <div class="col-lg-12">
          <div class="card">
              <div class="card-header align-items-center d-flex">
                  <h4 class="card-title mb-0 flex-grow-1">Thêm mới biến thể màu</h4>
              </div><!-- end card header -->
              <div class="card-body">
                  <div class="live-preview">
                      <div class="row gy-4">
                        <div class="col-4">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control @error('name')is-invalid @enderror" value="{{old('name')}}">
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