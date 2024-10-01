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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('type', ['deposit', 'withdrawal', 'pending']);  // نوع المعاملة
            $table->unsignedBigInteger('withdrawal_request_id')->nullable();
            $table->unsignedBigInteger('article_id')->nullable();

            $table->decimal('amount', 10, 2);  // المبلغ
            $table->text('description')->nullable(); // وصف الحركة
            $table->date('date')->nullable(); // وصف الحركة

            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');  
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');  
            $table->foreign('withdrawal_request_id')->references('id')->on('withdrawal_requests')->onDelete('cascade');  

          });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
