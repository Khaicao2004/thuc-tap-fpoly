<?php

use App\Models\Supplier;
use App\Models\User;
use App\Models\WareHouse;
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
        Schema::create('import_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(WareHouse::class)->constrained();
            $table->foreignIdFor(Supplier::class)->constrained();
            $table->double('total')->comment('tổng tiền');
            $table->double('price_paid')->comment('giá trả');
            $table->double('still_in_debt')->comment('còn nợ');
            $table->dateTime('date_added')->comment('ngày nhập');
            $table->text('note')->nullable();
            $table->enum('status', ['chua_thanh_toan', 'thanh_toan_mot_phan', 'da_thanh_toan', 'qua_han'])->default('chua_thanh_toan');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_orders');
    }
};
