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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('mobil_id')->constrained();
            $table->date('rent_date');
            $table->date('return_date');
            $table->integer('number_of_cars');
            $table->decimal('total_cost', 12,2);
            $table->enum('payment_status', ['pending', 'lunas'])->default('pending');
            $table->enum('payment_type', ['cash', 'transfer'])->default('cash');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
