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
        Schema::create('period_closings', function (Blueprint $table) {
            $table->id();
            $table->date('period_date'); // Tanggal closing (misal: akhir bulan)
            $table->decimal('calculated_cash', 15, 2); // Kas hasil kalkulasi
            $table->decimal('confirmed_cash', 15, 2)->nullable(); // Kas setelah konfirmasi
            $table->decimal('modal_inti', 15, 2)->nullable(); // Modal inti setelah konfirmasi
            $table->decimal('total_revenue', 15, 2);
            $table->decimal('total_expenses', 15, 2);
            $table->decimal('total_salaries', 15, 2);
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'rejected'])->default('pending');
            $table->unsignedBigInteger('confirmed_by')->nullable(); // Remove foreign key constraint
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('period_closings');
    }
};
