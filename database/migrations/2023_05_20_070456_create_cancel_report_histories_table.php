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
        Schema::create('cancel_report_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('amount')->default(0);
            $table->string('description')->nullable();
            $table->string('type')->nullable();
            $table->foreignId('reporter_id')->comment('reporter');
            $table->foreignId('rejecter_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancel_report_histories');
    }
};
