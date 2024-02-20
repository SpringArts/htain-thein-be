<?php

use App\Enums\FinancialType;
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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('amount')->default(0);
            $table->string('description')->nullable();
            $table->enum('type', [FinancialType::INCOME, FinancialType::EXPENSE])->nullable();
            $table->boolean('confirm_status')->default(false);
            $table->foreignId('reporter_id')->comment('reporter');
            $table->foreignId('verifier_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
