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
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_access_token')->nullable(); // لحفظ البيانات الخاصة بـ Google Access Token
            $table->string('google_refresh_token')->nullable(); // لحفظ البيانات الخاصة بـ Google Refresh Token
            $table->timestamp('token_expires_at')->nullable(); // لحفظ تاريخ انتهاء صلاحية التوكن


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
