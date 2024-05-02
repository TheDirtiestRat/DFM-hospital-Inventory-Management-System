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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->text('case_no');

            $table->string('first_name');
            $table->string('mid_name');
            $table->string('last_name');

            $table->date('birth_date');
            $table->integer('age');
            $table->string('birth_place');
            $table->text('blood_type');

            $table->string('gender');
            $table->string('religion');
            $table->string('citizenship');

            $table->text('contact_no');
            $table->string('barangay');
            $table->string('address');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient');
    }
};
