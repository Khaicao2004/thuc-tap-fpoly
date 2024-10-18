<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCatelogueRequest;
use App\Http\Requests\UpdateCatelogueRequest;
use App\Models\Catalogue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class CatalogueController extends Controller
{
    const PATH_VIEW = 'admin.catalogues.';
    const PATH_UPLOAD = 'catalogues';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    if ($request->ajax()) {
        $query = Catalogue::with('parent', 'children')->latest('id');

        // Lọc theo ngày tháng nếu có
        if ($request->has('startDate') && $request->has('endDate')) {
            $startDate = $request->get('startDate');
            $endDate = $request->get('endDate');

            if ($startDate && $endDate) {
                // Chuyển đổi định dạng ngày để bao gồm cả ngày
                $startDate = \Carbon\Carbon::parse($startDate)->startOfDay();
                $endDate = \Carbon\Carbon::parse($endDate)->endOfDay();

                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        return DataTables::of($query)
            ->addColumn('cover', function($row) {
                return asset(Storage::url($row->cover)); // URL hình ảnh
            })
            ->addColumn('children', function($row) {
                return $row->children->pluck('name')->toArray(); // Lấy tên danh mục con
            })
            ->addColumn('is_active', function($row) {
                return $row->is_active ? '<span class="badge bg-primary">YES</span>' : '<span class="badge bg-danger">NO</span>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.catalogues.edit', $row->id);
                $deleteUrl = route('admin.catalogues.destroy', $row->id);

                return '
                    <a href="' . $editUrl . '" class="btn btn-warning">Sửa</a>
                    <form action="' . $deleteUrl . '" method="post" style="display:inline;">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger" onclick="return confirm(\'Bạn có chắc chắn muốn xóa?\')">Xóa</button>
                    </form>
                ';
            })
            ->rawColumns(['cover', 'children', 'is_active', 'action'])
            ->make(true);
    }

    return view('admin.catalogues.index');
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentCategories = Catalogue::query()->with(['children'])->whereNull('parent_id')->get();
        // dd($parentCategories);
        return view(self::PATH_VIEW . __FUNCTION__, compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCatelogueRequest $storeCatelogueRequest)
    {
        try {
            $data = $storeCatelogueRequest->except('cover');

            $data['is_active'] = isset($data['is_active']) ? 1 : 0;
            // dd($data);

            $data['slug'] = Str::slug($storeCatelogueRequest->name);
            // $data = $storeCatelogueRequest->all();
            if($storeCatelogueRequest->hasFile('cover')){
                $data['cover'] = Storage::put(self::PATH_UPLOAD, $storeCatelogueRequest->file('cover'));
            }
            // dd($data);
            Catalogue::query()->create($data);
            return redirect()
            ->route('admin.catalogues.index')
            ->with('success','Thêm thành công');
        } catch (\Exception $exception) {
            Log::error('Lỗi thêm danh mục ' . $exception->getMessage());
            // dd($exception->getMessage());
            return back()->with('error', 'Lỗi thêm danh mục');
        }
    }

    

    /**
     * Display the specified resource.
     */
    public function show(Catalogue $catalogue)
    {
       

        return view(self::PATH_VIEW . __FUNCTION__, compact('catalogue'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Catalogue $catalogue)
    {
        $parentCatalogue = Catalogue::query()->with(['children'])->whereNull('parent_id')->get();
        // dd($parentCatalogue);    
        return view(self::PATH_VIEW . __FUNCTION__, compact('catalogue','parentCatalogue'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCatelogueRequest $request, Catalogue $catalogue)
    {
        try {
            $data = $request->except('cover');
            $data['is_active'] ??= 0;
            $data['slug'] = Str::slug($request->name);
            
            if($request->hasFile('cover')){
                $data['cover'] = Storage::put(self::PATH_UPLOAD, $request->file('cover'));
            }
            $oldImg=$catalogue->cover;
            $catalogue->update($data);
            if ($request->hasFile('cover') && $oldImg && Storage::exists($oldImg)) {
                Storage::delete($oldImg);
            }

            return redirect()
                ->route('admin.catalogues.index')
                ->with('success', 'Cập nhật thành công');
        } catch (\Exception $exception) {
            Log::error('Lỗi cập nhật danh mục: ' . $exception->getMessage());
            return back()->with('error', 'Lỗi cập nhật danh mục');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model = Catalogue::query()->findOrFail($id);

        $model->delete();

        if ($model->cover && Storage::exists($model->cover)) {
            Storage::delete($model->cover);
        }

        return back();
    }
}
