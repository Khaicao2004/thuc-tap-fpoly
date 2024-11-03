<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use App\Models\ImportOrder;
use App\Models\ImportOrderDetail;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductVariant;
use App\Models\Supplier;
use App\Models\Tag;
use App\Models\User;
use App\Models\WareHouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImportOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lấy dữ liệu của ImportOrder với quan hệ user, warehouse, supplier
        $data = ImportOrder::query()
            ->with(['user', 'warehouse', 'supplier']) // Lấy dữ liệu từ các bảng liên quan
            ->latest('id') // Lấy các phiếu nhập theo thứ tự mới nhất
            ->get();

        // Truyền dữ liệu cho view
        return view('admin.importorders.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $suppliers       = Supplier::query()->get();
        $warehouses      = WareHouse::query()->get();
        $poduct          = Product::query()->get(); // Nếu cần để chọn thuốc
        $users           = User::query()->get(); // Nếu cần để chọn người dùng
        $productvariants = ProductVariant::query()->get();
        $catalogues      = Catalogue::pluck('name', 'id');
        $colors          = ProductColor::query()->pluck('name', 'id')->all();
        $sizes           = ProductSize::query()->pluck('name', 'id')->all();
        $tags            = Tag::query()->pluck('name', 'id')->all();

        return view('admin.importorders.create', compact('suppliers', 'warehouses', 'poduct', 'users', 'productvariants', 'catalogues', 'colors', 'sizes', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Kiểm tra toàn bộ dữ liệu request
            // dd($request->all());

            // Tạo đơn nhập kho
            $importOrder = ImportOrder::create([
                'user_id' => $request->user_id,
                'storage_id' => $request->storage_id,
                'supplier_id' => $request->supplier_id,
                'price_paid' => $request->price_paid,
                'still_in_debt' => $request->still_in_debt,
                'status' => $request->status,
                'note' => $request->note,
                'total' => is_array($request->details) ? array_sum(array_column($request->details, 'total')) : 0,
                'date_added' => now(),
            ]);

            // Kiểm tra sau khi tạo đơn nhập kho
            // dd($importOrder);

            // Kiểm tra xem $request->details có phải là mảng và không rỗng
            if (isset($request->details) && is_array($request->details) && count($request->details) > 0) {
                foreach ($request->details as $detail) {
                    // Kiểm tra sản phẩm đã tồn tại dựa trên SKU
                    $existingProduct = Product::where('sku', $detail['sku'])->first();

                    if ($existingProduct) {
                        $productId = $existingProduct->id;
                        // Nếu sản phẩm đã tồn tại, thêm tiền tố ngày vào tên sản phẩm
                        $detail['name'] = $existingProduct->name . ' ' . now()->format('d/m/Y');
                    } else {
                        // Tạo sản phẩm mới
                        $newProduct = Product::create($detail);
                        $productId = $newProduct->id;
                    }

                    // Kiểm tra xem biến thể sản phẩm có tồn tại và là mảng hợp lệ
                    if (isset($detail['variants']) && is_array($detail['variants']) && count($detail['variants']) > 0) {
                        foreach ($detail['variants'] as $item) {
                            // Gán 'product_id' vào biến thể
                            $item['product_id'] = $productId;

                            // Tạo biến thể sản phẩm
                            $productVariant = ProductVariant::create($item);

                            // Cập nhật kho hàng
                            Inventory::create([
                                'ware_house_id' => $request->storage_id,
                                'product_variant_id' => $productVariant->id,
                                'quantity' => $item['quantity'],
                            ]);

                            // Kiểm tra và đảm bảo các trường hợp hợp lệ
                            $productName = $detail['name'] ?? 'Unnamed Product';
                            $quantity = $detail['quantity'] ?? 0;
                            $priceImport = $detail['price_import'] ?? 0;

                            // Lưu chi tiết nhập kho
                            ImportOrderDetail::create([
                                'import_order_id' => $importOrder->id,
                                'product_id' => $productId,
                                'product_variant_id' => $productVariant->id,
                                'product_name' => $productName,
                                'quantity' => $quantity,
                                'price_import' => $priceImport,
                                'total_price' => $quantity * $priceImport,
                                'date_added' => now(),
                                'note' => $detail['note'] ?? null,
                            ]);
                        }
                    }
                }
            } else {
                return back()->withErrors('Dữ liệu sản phẩm không hợp lệ.');
            }

            DB::commit();
            return redirect()->route('admin.importorders.index')
                ->with('success', 'Thêm đơn nhập kho thành công');
        } catch (\Exception $exception) {
            DB::rollBack();

            // Ghi lỗi vào logs
            Log::error('Lỗi khi tạo đơn nhập kho: ' . $exception->getMessage(), [
                'request_data' => $request->all(), // Ghi lại dữ liệu yêu cầu
                'exception_trace' => $exception->getTraceAsString() // Ghi lại trace của lỗi
            ]);

            // Kiểm tra $request->details trước khi thực hiện xóa ảnh
            if (isset($request->details) && is_array($request->details)) {
                foreach ($request->details as $detail) {
                    // Xóa ảnh thumbnail nếu tồn tại
                    if (!empty($detail['img_thumbnail']) && Storage::exists($detail['img_thumbnail'])) {
                        Storage::delete($detail['img_thumbnail']);
                    }

                    // Xóa ảnh trong biến thể nếu tồn tại
                    if (isset($detail['variants']) && is_array($detail['variants'])) {
                        foreach ($detail['variants'] as $item) {
                            if (!empty($item['image']) && Storage::exists($item['image'])) {
                                Storage::delete($item['image']);
                            }
                        }
                    }
                }
            }

            // Trả về thông báo lỗi cho người dùng
            return back()->with('error', 'Đã xảy ra lỗi: ' . $exception->getMessage());
        }
    }




    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Lấy đơn hàng nhập kho và các chi tiết của nó
        $importOrder = ImportOrder::with('details.product', 'details.productVariant')->findOrFail($id);

        return view('admin.importorders.show', compact('importOrder'));
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
    public function destroy($id)
    {

        // Tìm kiếm bản ghi theo ID
        $importOrder = ImportOrder::find($id);

        if ($importOrder) {
            // Xóa tất cả các chi tiết liên quan trước
            DB::table('import_order_details')->where('import_order_id', $id)->delete();

            // Xóa bản ghi chính
            $importOrder->delete();

            // Đưa người dùng trở lại trang danh sách với thông báo thành công
            return redirect()->route('admin.importorder.index')->with('success', 'Đơn hàng đã được xóa thành công.');
        }

        // Nếu không tìm thấy bản ghi, quay lại với thông báo lỗi
        return redirect()->route('admin.importorder.index')->with('error', 'Đơn hàng không tồn tại.');
    }
}
