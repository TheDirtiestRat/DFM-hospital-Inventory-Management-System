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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();

            $table->text('medicine_id');

            $table->string('name');
            $table->string('manufacturer');
            $table->string('type');

            $table->text('package_type');
            $table->text('mesurement');
            $table->text('mesurement_value');
            $table->integer('quantity');

            $table->text('photo');
            $table->text('batch_no');
            $table->string('description')->nullable();

            $table->date('expired_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
