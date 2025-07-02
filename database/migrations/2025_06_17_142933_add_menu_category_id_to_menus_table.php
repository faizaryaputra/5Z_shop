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
    Schema::table('menus', function (Blueprint $table) {
        $table->unsignedBigInteger('menu_category_id')->nullable()->after('price');
        $table->foreign('menu_category_id')->references('id')->on('menu_categories')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('menus', function (Blueprint $table) {
        $table->dropForeign(['menu_category_id']);
        $table->dropColumn('menu_category_id');
    });
}

};
