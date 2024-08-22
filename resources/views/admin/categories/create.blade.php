@extends('admin.layouts.master')

@section('title')
    Thêm mới danh mục sản phẩm
@endsection

@section('content')
  <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Thêm mới danh mục</h4>
                </div><!-- end card header -->
                <div class="card-body">
                  <div class="live-preview">
                      <div class="row gy-4">
                          <div class="col-md-4">
                              <div>
                                  <label for="name" class="form-label">Name</label>
                                  <input type="text" id="name" name="name" class="form-control @error('name')is-invalid @enderror" value="{{old('name')}}">
                                  <div class="invalid-feedback">
                                      @error('name')
                                          {{ $message }}
                                      @enderror
                                  </div>
                              </div>
                              <div class="mt-3">
                                  <label for="cover" class="form-label">Cover</label>
                                  <input type="file" id="cover" name="cover" class="form-control @error('cover')is-invalid @enderror" value="{{old('cover')}}">
                                  <div class="invalid-feedback">
                                    @error('cover')
                                        {{ $message }}
                                    @enderror
                                </div>
                              </div>
                          </div>
                          <div class="col-md-8">
                              <div class="row">
                                  <div class="col-md-2">
                                      <div class="form-check form-switch form-switch-primary">
                                          <input class="form-check-input" type="checkbox" role="switch"
                                              cover="is_active" id="is_active" value="1" checked>
                                          <label class="form-check-label" for="is_active">Is Active</label>
                                      </div>
                                  </div>
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
