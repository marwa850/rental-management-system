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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('house_id');
            $table->unsignedBigInteger('renter_id');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->decimal('price_per_month', 10, 2)->nullable();
            $table->text('notes')->nullable();
             $table->foreign('house_id')
                  ->references('id')->on('houses')
                  ->onDelete('cascade');

            $table->foreign('renter_id')
                  ->references('id')->on('renters')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
