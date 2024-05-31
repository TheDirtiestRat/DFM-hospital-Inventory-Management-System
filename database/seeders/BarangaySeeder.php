<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Region South
        DB::table('barangay_list')->insert([
            'region' => 'South',
            'barangay' => 'District 1'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'South',
            'barangay' => 'District 2'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'South',
            'barangay' => 'District 3'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'South',
            'barangay' => 'District 4'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'South',
            'barangay' => 'District 5'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'South',
            'barangay' => 'District 6'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'South',
            'barangay' => 'District 7'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'South',
            'barangay' => 'District 8'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'South',
            'barangay' => 'District 12'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'South',
            'barangay' => 'District 13'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'South',
            'barangay' => 'District 15'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'South',
            'barangay' => 'District 17'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'South',
            'barangay' => 'District 23'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'South',
            'barangay' => 'District 27'
        ]);

        // Region West
        DB::table('barangay_list')->insert([
            'region' => 'West',
            'barangay' => 'District 14'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'West',
            'barangay' => 'District 19'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'West',
            'barangay' => 'District 20'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'West',
            'barangay' => 'District 21'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'West',
            'barangay' => 'District 22'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'West',
            'barangay' => 'District 24'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'West',
            'barangay' => 'District 26'
        ]);

        // Region East
        DB::table('barangay_list')->insert([
            'region' => 'East',
            'barangay' => 'District 9'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'East',
            'barangay' => 'District 10'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'East',
            'barangay' => 'District 11'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'East',
            'barangay' => 'District 16'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'East',
            'barangay' => 'District 18'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'East',
            'barangay' => 'District 25'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'East',
            'barangay' => 'District 28'
        ]);

        // Region North
        DB::table('barangay_list')->insert([
            'region' => 'North',
            'barangay' => 'District 29'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'North',
            'barangay' => 'Cogon'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'North',
            'barangay' => 'Altavista'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'North',
            'barangay' => 'Patag'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'North',
            'barangay' => 'Doña Feliza (DFL)'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'North',
            'barangay' => 'Donghol'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'North',
            'barangay' => 'Mahayag'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'North',
            'barangay' => 'Bagong Buhay'
        ]);
        DB::table('barangay_list')->insert([
            'region' => 'North',
            'barangay' => 'San Isidro'
        ]);
    }
}
