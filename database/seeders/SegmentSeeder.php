<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SegmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('segments')->insert([
            'segment_name' => 'Production Number',
            'percentage' => 20,
            'event_id' => 1
        ]);

        DB::table('segments')->insert([
            'segment_name' => 'Swimsuit / Sports Attire',
            'percentage' => 20,
            'event_id' => 1
        ]);
    }
}
