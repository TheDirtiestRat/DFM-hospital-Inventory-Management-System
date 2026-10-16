<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->decimal('strength_value', 10, 3)->nullable();
            $table->string('strength_unit', 10)->nullable();
            $table->string('dispensing_unit', 30)->default('unit');
            $table->unsignedInteger('units_per_package')->default(1);
        });

        foreach (DB::table('medicines')->select('id', 'mesurement_value', 'mesurement')->get() as $medicine) {
            $unit = match (strtolower(trim((string) $medicine->mesurement))) {
                'mm', 'mg' => 'mg',
                'mcg', 'ug', 'µg' => 'mcg',
                'g' => 'g',
                'ml' => 'mL',
                'l' => 'L',
                'iu' => 'IU',
                default => null,
            };

            if ($unit !== null && is_numeric($medicine->mesurement_value)) {
                DB::table('medicines')
                    ->where('id', $medicine->id)
                    ->update([
                        'strength_value' => $medicine->mesurement_value,
                        'strength_unit' => $unit,
                    ]);
            }

            $dispensingUnit = match (strtolower(trim((string) $medicine->package_type))) {
                'tablet', 'tablets' => 'tablet',
                'capsule', 'capsules', 'capstule' => 'capsule',
                default => 'unit',
            };

            DB::table('medicines')
                ->where('id', $medicine->id)
                ->update([
                    'dispensing_unit' => $dispensingUnit,
                    'package_type' => match (strtolower(trim((string) $medicine->package_type))) {
                        'pads', 'capstule', 'tablets' => 'strip',
                        'box' => 'box',
                        'bottle' => 'bottle',
                        'bags' => 'bag',
                        default => $medicine->package_type,
                    },
                ]);
        }
    }

    public function down(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->dropColumn([
                'strength_value',
                'strength_unit',
                'dispensing_unit',
                'units_per_package',
            ]);
        });
    }
};
