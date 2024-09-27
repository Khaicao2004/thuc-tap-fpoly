<?php

use App\Models\Coupon;
use App\Models\Order;
use App\Models\User;
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
        Schema::create('coupon_user', function (Blueprint $table) {
            $table->foreignIdFor(Coupon::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->unsignedInteger('usage_count')->default(0); // Số lần mã được sử dụng bởi người dùng
            $table->timestamp('used_at')->nullable();  // Thời điểm mã giảm giá được sử dụng

            $table->primary([ 'coupon_id','user_id' ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_user');
    }
};
