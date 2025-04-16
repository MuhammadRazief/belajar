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
        Schema::create('sales', function (Blueprint $table) {
            $table->id(); // This will create an unsigned BIGINT as a primary key.
            
            // Other fields
            $table->date('sale_date');
            $table->integer('total_price');
            $table->integer('total_pay');
            $table->integer('total_return');
            
            // Make customer_id nullable and declare it as unsignedBigInteger
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('user_id');
            
            // Foreign key constraints
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('restrict');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            
            // Points system (optional fields)
            $table->integer('poin')->nullable();
            $table->integer('used_point')->nullable();
            
            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
