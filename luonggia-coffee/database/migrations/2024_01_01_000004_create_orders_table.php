<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            
            // Thông tin khách hàng đặt online
            $table->string('customer_name')->nullable();
            $table->string('customer_phone', 20)->nullable();
            $table->string('customer_address')->nullable();
            
            $table->string('code', 30)->unique();
            
            // Cột Voucher và Giảm giá
            $table->string('voucher_code')->nullable();
            $table->integer('discount_amount')->default(0);
            
            $table->decimal('total', 12, 0)->default(0);
            $table->enum('status', ['pending','paid','cancelled'])->default('pending');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('orders'); }
};