<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['cancel_sale', 'void_item', 'post_void']);
            $table->foreignId('cashier_id')->constrained('users');
            $table->foreignId('transaction_id')->nullable()->constrained('transactions')->nullOnDelete();
            $table->string('product_name')->nullable();
            $table->string('receipt_no')->nullable();
            $table->text('reason')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->json('items')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('audit_logs');
    }
};
