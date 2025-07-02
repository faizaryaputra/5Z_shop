<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->after('user_id')->nullable();

            // Jika ingin relasi (opsional):
            // $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Jika kamu pakai foreign key
            // $table->dropForeign(['order_id']);
            $table->dropColumn('order_id');
        });
    }
};
