<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    const PATH_VIEW = 'admin.comments.';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Comment::query()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return back()->with('success', 'Xóa bình luận thành công');
    }

    public function getRestore()
    {
        $data = Comment::onlyTrashed()->get();
        return view('admin.comments.restore', compact('data'));
    }
    public function restore(Request $request)
    { 
        // dd($request->all());
        try {
            $CommentIds = $request->input('ids');
            if ($CommentIds) {
                Comment::onlyTrashed()->whereIn('id', $CommentIds)->restore();
                return back()->with('success', 'Khôi phục bản ghi thành công.');
            } else {
                return back()->with('error', 'Không bản ghi nào cần khôi phục.');
            }
        } catch (\Exception $exception) {
            Log::error('Lỗi xảy ra: ' . $exception->getMessage());
            return back()->with('error', 'Khôi phục bản ghi thất bại.');
        }
    }
}
