<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('description')->nullable();
            $table->enum('type', ['percentage', 'fixed']); // Persentase atau nominal
            $table->decimal('value', 10, 2); // Nilai promo (contoh: 10% atau Rp 10.000)
            $table->date('expiry_date'); // Tanggal berakhir
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('promos');
    }
};
