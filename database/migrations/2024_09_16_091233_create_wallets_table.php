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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('balance', 10, 2)->default(0);  // الرصيد المتاح
            $table->decimal('pending_balance', 10, 2)->default(0);  // الرصيد المعلق
            $table->decimal('withdrawn_balance', 10, 2)->default(0);  // الرصيد المسحوب
            $table->decimal('last_earning', 10, 2)->default(0);  // الرصيد المسحوب

            
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
