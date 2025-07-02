<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAvatarToUsersTable extends Migration

{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        if (!Schema::hasColumn('users', 'avatar')) {
            $table->string('avatar')->nullable();
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('users', function (Blueprint $table) {
        if (Schema::hasColumn('users', 'avatar')) {
            $table->dropColumn('avatar');
        }
    });
}

};
