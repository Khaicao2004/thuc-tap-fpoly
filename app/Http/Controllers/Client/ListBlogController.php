<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class ListBlogController extends Controller
{
    public function list()
    {
        $data = Blog::query()->latest()->take(9)->get();
        return view('client.blog', compact('data'));
    }

   
    public function show($id)
    {
        $blog = Blog::findOrFail($id);

        // Lấy bài viết trước và bài viết tiếp theo
        $previousBlog = Blog::where('id', '<', $blog->id)->orderBy('id', 'desc')->first();
        $nextBlog = Blog::where('id', '>', $blog->id)->orderBy('id', 'asc')->first();

        return view('client.blog-details', compact('blog', 'previousBlog', 'nextBlog'));
    }
}
