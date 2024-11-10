<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const PATH_VIEW = 'admin.users.';
    public function index()
    {

        $data = User::query()->latest('id')->get();
        //   dd($data); 
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
    public function store(StoreUserRequest $request)
    {
        try {
            $data = $request->all();
            User::create($data);
            return redirect()->route('admin.users.index')->with('success', 'Thêm Thành công');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        try {
            $model = User::query()->findOrFail($id);

            $data = $request->all();
            $model->update($data);

            return back()->with('success', 'Sửa Thành công');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model = User::query()->findOrFail($id);

        $model->delete();

        return back()->with('success', 'Xóa Thành công');
    }

    public function getRestore()
    {
        $data = User::onlyTrashed()->get();
        return view('admin.Users.restore', compact('data'));
    }
    public function restore(Request $request)
    {
        // dd($request->all());
        try {
            $UserIds = $request->input('ids');
            if ($UserIds) {
                User::onlyTrashed()->whereIn('id', $UserIds)->restore();
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
