<?php

use App\Models\ImportOrder;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('import_order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ImportOrder::class)->constrained();
            $table->foreignIdFor(Product::class)->constrained();
            $table->foreignIdFor(ProductVariant::class)->constrained();
            $table->string('product_name'); // Tên sản phẩm (có thể có tiền tố ngày đăng nếu trùng)
            $table->integer('quantity'); // Số lượng nhập
            $table->decimal('price_import'); // Giá nhập cho mỗi đơn vị sản phẩm
            $table->decimal('total_price'); // Tổng giá trị cho mặt hàng này (số lượng * giá nhập)
            $table->dateTime('date_added')->comment('ngày nhập');
            $table->text('note')->nullable(); // Ghi chú cho chi tiết sản phẩm
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_order_details');
    }
};
