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
        Schema::create('business_settings', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->date('start_date'); // Tanggal mulai bisnis
            $table->decimal('initial_capital', 15, 2); // Modal awal
            $table->decimal('current_cash', 15, 2); // Kas saat ini
            $table->decimal('target_monthly_revenue', 15, 2)->nullable(); // Target pendapatan bulanan
            $table->decimal('minimum_cash_reserve', 15, 2)->nullable(); // Minimum kas yang harus dijaga
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_settings');
    }
};
