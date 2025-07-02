<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Ubah kolom 'status' dari enum menjadi string
            $table->string('status')->default('pending')->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Kembalikan ke enum jika rollback
            $table->enum('status', ['pending', 'processing', 'completed', 'canceled'])->default('pending')->change();
        });
    }
};
