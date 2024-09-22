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

class CatalogueController extends Controller
{
    const PATH_VIEW = 'admin.catalogues.';
    const PATH_UPLOAD = 'catalogues';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Catalogue::query()->latest('id')->get();
        // dd($data);
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentCategories = Catalogue::query()->with(['children'])->whereNull('parent_id')->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('parentCategories'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCatelogueRequest $storeCatelogueRequest)
    {


        try {
            $data = $storeCatelogueRequest->except('cover');
            $data['is_active'] ??= 0;
            $data['slug'] = Str::slug($storeCatelogueRequest->name);
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

        if($model->cover && Storage::exists($model->cover)){
            Storage::delete($model->cover);
        }

        return back();
    }
}
