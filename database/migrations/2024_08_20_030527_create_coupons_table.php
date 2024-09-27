<?php

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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->decimal('discount_value', 10, 2);  // Giá trị giảm
            $table->date('start_date')->nullable();  // Ngày bắt đầu hiệu lực của mã
            $table->date('end_date')->nullable();  // Ngày kết thúc hiệu lực của mã
            $table->decimal('min_order_value', 10, 2)->nullable();  // Giá trị đơn hàng tối thiểu để sử dụng mã
            $table->unsignedInteger('usage_limit')->nullable();  // Giới hạn số lần mã được sử dụng
            $table->unsignedInteger('used')->default(0);  // Số lần mã đã được sử dụng
            $table->unsignedInteger('max_usage_per_user')->nullable();  // Số lần tối đa mã có thể sử dụng bởi mỗi người dùng
            $table->string('description')->nullable();  // Mô tả cho mã giảm giá
            $table->boolean('is_active')->default(true);  // Trạng thái mã giảm giá (còn hiệu lực hay không)
            $table->enum('discount_type', ['fixed_product', 'fixed_cart', 'percent_product', 'percent_cart']);  // Kiểu giảm giá: cố định hoặc phần trăm
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
