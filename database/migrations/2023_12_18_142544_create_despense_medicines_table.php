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
        Schema::create('despense_medicines', function (Blueprint $table) {
            $table->id();
            $table->string('despenser');
            $table->string('despensed');
            $table->string('medicine');
            $table->string('diagnosis');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('despense_medicines');
    }
};
