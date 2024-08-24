@extends('admin.layouts.master')

@section('title')
    Xem chi tiết danh mục sản phẩm: {{ $productsize->name }}
@endsection

@section('content')
<table class="table table-bodered">
    <tr>
        <th>Trường</th>
        <th>Giá trị</th>
    </tr>
    @foreach ($productsize->toArray() as $key => $value)     
    <tr>
        <td>{{ $key }}</td>
        <td>{{ $value }}</td>
    </tr>
    @endforeach
</table>
@endsection