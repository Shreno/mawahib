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
        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['Zain Cash', 'USDT Binance', 'Payoneer']);
            $table->string('payment_details')->nullable(); // لحفظ البيانات الخاصة بكل طريقة دفع
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('requested_at')->useCurrent(); // تاريخ طلب السحب
            $table->timestamp('approved_at')->nullable(); // تاريخ الموافقة
            $table->timestamp('rejected_at')->nullable(); // تاريخ الرفض

            $table->string('image_confirm')->nullable(); // لحفظ البيانات الخاصة بكل طريقة دفع

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawal_requests');
    }
};
