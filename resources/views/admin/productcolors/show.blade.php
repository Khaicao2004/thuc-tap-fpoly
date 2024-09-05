@extends('admin.layouts.master')

@section('title')
    Xem chi tiết danh mục sản phẩm: {{ $productcolor->name }}
@endsection

@section('content')
<table class="table table-bodered">
    <tr>
        <th>Trường</th>
        <th>Giá trị</th>
    </tr>
    @foreach ($productcolor->toArray() as $key => $value)     
    <tr>
        <td>{{ $key }}</td>
        <td>{{ $value }}</td>
    </tr>
    @endforeach
</table>
@endsection