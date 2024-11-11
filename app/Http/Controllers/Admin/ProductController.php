<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Catalogue;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductGallery;
use App\Models\ProductSize;
use App\Models\ProductVariant;
use App\Models\Supplier;
use App\Models\Tag;
use App\Models\WareHouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    const PATH_VIEW = 'admin.products.';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::query()->with(['catalogue', 'tags', 'supplier'])->latest('id')->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::query()->pluck('name', 'id')->all();
        $wareHouse = WareHouse::query()->pluck('name', 'id')->all();
        $catalogues = Catalogue::query()->pluck('name', 'id')->all();
        $colors = ProductColor::query()->pluck('name', 'id')->all();
        $sizes = ProductSize::query()->pluck('name', 'id')->all();
        $tags = Tag::query()->pluck('name', 'id')->all();
        return view(self::PATH_VIEW . __FUNCTION__, compact('catalogues', 'colors', 'sizes', 'tags', 'wareHouse',  'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        list(
            $dataProduct,
            $dataProductVariants,
            $dataProductGalleries,
            $dataProductTags
            ) = $this->handleData($request);

            // dd($dataProduct);
        try {
            DB::beginTransaction();

            $product = Product::query()->create($dataProduct);

            foreach ($dataProductVariants as $item) {
                $item += ['product_id' => $product->id];

                $productVariant = ProductVariant::query()->create($item);

                Inventory::create([
                    'ware_house_id' => $request->ware_house_id,
                    'product_variant_id' => $productVariant->id,
                    'quantity' => $item['quantity']
                ]);
            }

            $product->tags()->attach($dataProductTags);

            foreach ($dataProductGalleries as $item) {
                $item += ['product_id' => $product->id];

                ProductGallery::query()->create($item);
            }

            DB::commit();
            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Thêm sản phẩm thành công');
        } catch (\Exception $exception) {
            DB::rollBack();

            if (!empty($dataProduct['img_thumbnail'])
                && Storage::exists($dataProduct['img_thumbnail'])) {

                Storage::delete($dataProduct['img_thumbnail']);
            }

            $dataHasImage = $dataProductVariants + $dataProductGalleries;
            foreach ($dataHasImage as $item) {
                if (!empty($item['image']) && Storage::exists($item['image'])) {
                    Storage::delete($item['image']);
                }
            }
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $wareHouse = WareHouse::query()->pluck('name', 'id')->all();
        $catalogues = Catalogue::query()->pluck('name', 'id')->all();
        $colors = ProductColor::query()->pluck('name', 'id')->all();
        $sizes = ProductSize::query()->pluck('name', 'id')->all();
        $tags = Tag::query()->pluck('name', 'id')->all();
        $variants = Product::with('variants')->find($product->id)->variants;
        $galleries = Product::with('galleries')->find($product->id)->galleries;
        $productTags = Product::with('tags')->find($product->id)->tags;
        return view(self::PATH_VIEW . __FUNCTION__, compact('product', 'catalogues', 'colors', 'sizes', 'tags','variants', 'galleries', 'productTags', 'wareHouse'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $suppliers = Supplier::query()->pluck('name', 'id')->all();
        $wareHouse = WareHouse::query()->pluck('name', 'id')->all();
        $catalogues = Catalogue::query()->pluck('name', 'id')->all();
        $colors = ProductColor::query()->pluck('name', 'id')->all();
        $sizes = ProductSize::query()->pluck('name', 'id')->all();
        $tags = Tag::query()->pluck('name', 'id')->all();
        $variants = Product::with('variants')->find($product->id)->variants;
        $galleries = Product::with('galleries')->find($product->id)->galleries;
        $productTags = Product::with('tags')->find($product->id)->tags;
        return view(self::PATH_VIEW . __FUNCTION__, compact('product', 'catalogues', 'colors', 'sizes', 'tags', 'variants', 'galleries', 'productTags', 'wareHouse', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        list(
            $dataProduct,
            $dataProductVariants,
            $dataProductGalleries,
            $dataProductTags,
            $dataDeleteGalleries
            ) = $this->handleData($request);

        try {
            DB::beginTransaction();

            $productImgThumbnailCurrent = $product->img_thumbnail;

            $product->update($dataProduct);

            foreach ($dataProductVariants as $item) {
                $item += ['product_id' => $product->id];

                $productVariant = ProductVariant::query()->updateOrCreate(
                    [
                        'product_id' => $item['product_id'],
                        'product_size_id' => $item['product_size_id'],
                        'product_color_id' => $item['product_color_id'],
                    ],
                    $item
                );

                // Kiểm tra xem bản ghi trong Inventory đã tồn tại chưa
                $inventory = Inventory::query()->where([
                    'product_variant_id' => $productVariant->id,
                ])->first();

                if ($inventory) {
                    // Nếu bản ghi tồn tại, cập nhật quantity
                    $inventory->update([
                        'ware_house_id' => $request->ware_house_id,
                        'quantity' => $item['quantity'],
                        'updated_at' => now(),
                    ]);
                } else {
                    // Nếu không tồn tại, tạo mới bản ghi
                    Inventory::create([
                        'ware_house_id' => $request->ware_house_id,
                        'product_variant_id' => $productVariant->id,
                        'quantity' => $item['quantity']
                    ]);
                }
            }

            $product->tags()->sync($dataProductTags);

            foreach ($dataProductGalleries as $item) {
                $item += ['product_id' => $product->id];

                ProductGallery::query()->updateOrCreate(
                    [
                        'id' => $item['id']
                    ],
                    $item
                );
            }

            DB::commit();

            if (!empty($dataDeleteGalleries)) {
                foreach ($dataDeleteGalleries as $id => $path) {
                    ProductGallery::query()->where('id', $id)->delete();

                    if (!empty($path) && Storage::exists($path)) {
                        Storage::delete($path);
                    }
                }
            }

            if (!empty($productImgThumbnailCurrent) && Storage::exists($productImgThumbnailCurrent)) {
                Storage::delete($productImgThumbnailCurrent);
            }

            return back()->with('success', 'Thao tác thành công!');
        } catch (\Exception $exception) {
            DB::rollBack();

            if (!empty($dataProduct['img_thumbnail'])
                && Storage::exists($dataProduct['img_thumbnail'])) {

                Storage::delete($dataProduct['img_thumbnail']);
            }

            $dataHasImage = $dataProductVariants + $dataProductGalleries;
            foreach ($dataHasImage as $item) {
                if (!empty($item['image']) && Storage::exists($item['image'])) {
                    Storage::delete($item['image']);
                }
            }

            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            $dataHasImage = $product->galleries->toArray() + $product->variants->toArray();
            DB::transaction(function () use ($product) {
                $product->tags()->sync([]);

                $product->galleries()->delete();

                foreach ($product->variants as $variant) {
                    $variant->orderItems()->delete();
                }
                $product->variants()->delete();

                $product->delete();
            }, 3);
            foreach ($dataHasImage as $item) {
                if (!empty($item->image) && Storage::exists($item->image)) {
                    Storage::delete($item->image);
                }
            }
            return redirect()->route('admin.products.index')->with('success', 'Xóa thành công');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    private function handleData(StoreProductRequest|UpdateProductRequest $request)
    {
        $dataProduct = $request->except(['product_variants', 'tags', 'product_galleries']);
        $dataProduct['is_active'] = isset($dataProduct['is_active']) ? 1 : 0;
        $dataProduct['is_hot_deal'] = isset($dataProduct['is_hot_deal']) ? 1 : 0;
        $dataProduct['is_good_deal'] = isset($dataProduct['is_good_deal']) ? 1 : 0;
        $dataProduct['is_new'] = isset($dataProduct['is_new']) ? 1 : 0;
        $dataProduct['is_show_home'] = isset($dataProduct['is_show_home']) ? 1 : 0;
        $dataProduct['slug'] = Str::slug($dataProduct['name']) . '-' . $dataProduct['sku'];

        // Kiểm tra và lưu hình ảnh thumbnail
        if ($request->hasFile('img_thumbnail')) {
            $image = $request->file('img_thumbnail');
            $dataProduct['img_thumbnail'] = $image->store('products', 'public');
        } else {
            $dataProduct['img_thumbnail'] = $request->input('current_img_thumbnail'); // Giữ nguyên ảnh hiện tại
        }

        // Xử lý biến thể
        $dataProductVariantsTmp = $request->product_variants;
        $dataProductVariants = [];
        foreach ($dataProductVariantsTmp as $key => $item) {
            $tmp = explode('-', $key);

            if (!empty($item['image'])) {
                $image = $item['image']->store('product_variants', 'public');
            } else {
                $image = $item['current_image'] ?? null; // Giữ nguyên ảnh hiện tại nếu không tải lên ảnh mới
            }

            $dataProductVariants[] = [
                'product_size_id' => $tmp[0],
                'product_color_id' => $tmp[1],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'image' => $image
            ];
        }

        // Xử lý hình ảnh thư viện
        $dataProductGalleriesTmp = $request->product_galleries ?: [];
        $dataProductGalleries = [];
        foreach ($dataProductGalleriesTmp as $image) {
            if (!empty($image)) {
                $dataProductGalleries[] = [
                    'image' => $image->store('product_galleries', 'public')
                ];
            }
        }

        $dataProductTags = $request->tags;
        $dataDeleteGalleries = $request->delete_galleries;

        return [$dataProduct, $dataProductVariants, $dataProductGalleries, $dataProductTags, $dataDeleteGalleries];
    }

}
