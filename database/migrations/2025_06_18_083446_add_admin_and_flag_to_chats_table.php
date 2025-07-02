<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdminAndFlagToChatsTable extends Migration
{
    public function up()
    {
        Schema::table('chats', function (Blueprint $table) {
            if (!Schema::hasColumn('chats', 'admin_id')) {
                $table->unsignedBigInteger('admin_id')->nullable()->after('user_id');
            }

            if (!Schema::hasColumn('chats', 'is_from_user')) {
                $table->boolean('is_from_user')->default(true)->after('admin_id');
            }
        });
    }

    public function down()
    {
        Schema::table('chats', function (Blueprint $table) {
            if (Schema::hasColumn('chats', 'admin_id')) {
                $table->dropColumn('admin_id');
            }

            if (Schema::hasColumn('chats', 'is_from_user')) {
                $table->dropColumn('is_from_user');
            }
        });
    }
}
