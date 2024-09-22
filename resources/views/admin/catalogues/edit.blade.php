@extends('admin.layouts.master')

@section('title')
    Câp nhật danh mục sản phẩm: {{ $catalogue->name }}
@endsection

@section('content')
<form action="{{route('admin.catalogues.update', $catalogue->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
      <div class="col-lg-12">
          <div class="card">
              <div class="card-header align-items-center d-flex">
                  <h4 class="card-title mb-0 flex-grow-1">Cập nhật danh mục</h4>
              </div><!-- end card header -->
              <div class="card-body">
                  <div class="live-preview">
                      <div class="row gy-4">
                          <div class="col-md-4">
                              <div>
                                  <label for="name" class="form-label">Name</label>
                                  <input type="text" class="form-control @error('name')is-invalid @enderror" id="name" name="name"  value="{{$catalogue->name}}">
                                  <div class="invalid-feedback">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </div>
                              </div>
                              <div class="col-6">
                                <label for="parent_id" class="form-label">Loại tin cha</label>
                                <select id="" class="js-example-basic-single form-control" name="parent_id"
                                    id="parent_id">
                                    @php($parent_id = $catalogue->parent_id)
                                    @foreach ($parentCatalogue as $parent)
                                    {{-- @dd($parent_id  ) --}}
                                        @php($each = ' ')
                                        @include('admin.catalogues.nested-category-edit', [
                                            'catalogue' => $parent,
                                            'parent_id' => $parent_id,
                                        ])
                                    @endforeach
                                </select>
                              </div>
                            <div class="mt-3">
                              <label for="cover" class="form-label">Cover</label>
                              <input type="file" class="form-control @error('name')is-invalid @enderror" id="cover" name="cover">
                              <div class="invalid-feedback">
                                @error('cover')
                                    {{ $message }}
                                @enderror
                            </div>
                              <img src="{{\Storage::url($catalogue->cover)}}" alt="" width="50px">
                          </div>        
                          </div>
                          <div class="col-md-8">
                           <div class="row">
                            <div class="col-md-2">
                              <div class="form-check form-switch form-switch-primary">
                                <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="is_active" value="1"   
                                 @if ($catalogue->is_active) checked @endif>
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