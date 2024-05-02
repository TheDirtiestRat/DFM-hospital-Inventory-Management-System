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
        Schema::create('batch_medicines', function (Blueprint $table) {
            $table->id();

            $table->text('batch_id');
            $table->text('batch_title');

            $table->text('medicine_id');

            $table->date('stock_date');
            $table->date('expired_date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch_medicines');
    }
};
