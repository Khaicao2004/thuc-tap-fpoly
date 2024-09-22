
<option value="{{ $catalogue->id }}" @if ($parent_id == $catalogue->id) selected @endif>
    {{ $each }}{{ $catalogue->name }}</option>
@if ($catalogue->children)
    @php($each .= '-')
    @foreach ($catalogue->children as $child)
        @include('admin.catalogues.nested-category-edit', ['catalogue' => $child])
    @endforeach
@endif
