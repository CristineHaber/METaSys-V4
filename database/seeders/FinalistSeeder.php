<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FinalistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('finalists')->insert([
            'finalist_name' => '3',
            'percentage' => 100,
            'event_id' => 1
        ]);

        DB::table('finalists')->insert([
            'finalist_name' => '5',
            'percentage' => 100,
            'event_id' => 1
        ]);
    }
}
