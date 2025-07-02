<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('transactions', function (Blueprint $table) {
        if (Schema::hasColumn('transactions', 'amount')) {
            $table->dropColumn('amount');
        }
    });
}


public function down()
{
    Schema::table('transactions', function (Blueprint $table) {
        $table->decimal('amount', 15, 2)->nullable(); // Atur sesuai tipe aslinya
    });
}
};
