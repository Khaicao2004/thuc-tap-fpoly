<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const PATH_VIEW = 'admin.tags.';
    public function index()
    {
        $data = Tag::query()->latest('id')->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagRequest $request)
    {
        // dd($request->toArray());
        $slug = $request->slug ?: Str::slug($request->name);
        try {
            $tag = Tag::create([
                'name' => $request->name,
                'slug' => $slug,
            ]);
            return redirect()->route('admin.tags.index')->with('success', 'Thêm tag thành công');
        } catch (\Exception $exception) {
            Log::error('Lỗi thêm tag ' . $exception->getMessage());
            return back()->with('error', 'Lỗi thêm tag');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        try {
            // Kiểm tra slug, nếu để trống thì tạo slug mới từ tên
            $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);

            // Cập nhật tag
            $tag->update([
                'name' => $request->name,
                'slug' => $slug,
            ]);

            return back()->with('success', 'Cập nhật tag thành công');
        } catch (\Exception $e) {
            Log::error('Lỗi cập nhật tag: ' . $e->getMessage());
            return back()->with('error', 'Lỗi cập nhật tag. Vui lòng thử lại.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        try {
            $tag->delete();
            return back()->with('success', 'Xóa tag thành công');
        } catch (\Exception $e) {
            Log::error('Lỗi xóa danh mục sản phẩm ' . $e->getMessage());
            return back()->with('error', 'Lỗi xóa tag');
        }
    }
}
