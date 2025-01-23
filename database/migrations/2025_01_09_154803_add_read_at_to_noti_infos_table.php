<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::table('noti_infos', function (Blueprint $table) {
            $table->timestamp('last_viewed_at')->nullable()->default(null);
        });
    }

    public function down(): void
    {
        Schema::table('noti_infos', function (Blueprint $table) {
            $table->dropColumn('last_viewed_at');
        });
    }
};
