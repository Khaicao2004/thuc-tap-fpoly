
<option value="{{ $catalogue->id }}">{{ $each }}{{ $catalogue->name }}</option>
@if ($catalogue->children)
    @php($each .= '-')
    @foreach ($catalogue->children as $child)
        @include('admin.catalogues.nested-category', ['catalogue' => $child])
    @endforeach
@endif
