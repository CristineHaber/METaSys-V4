<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('criterias')->insert([
            'criteria_name' => 'Beauty of the Face',
            'percentage' => '20',
            'event_id'=> 1,
            'segment_id'=> 1
        ]);

        DB::table('criterias')->insert([
            'criteria_name' => 'Confidence',
            'percentage' => '40',
            'event_id'=> 1,
            'segment_id'=> 1
        ]);

        DB::table('criterias')->insert([
            'criteria_name' => 'Audience Impact',
            'percentage' => '10',
            'event_id'=> 1,
            'segment_id'=> 1
        ]);

        
        DB::table('criterias')->insert([
            'criteria_name' => 'Mastery',
            'percentage' => '30',
            'event_id'=> 1,
            'segment_id'=> 1
        ]);

        //
        DB::table('criterias')->insert([
            'criteria_name' => 'Figure',
            'percentage' => '45',
            'event_id'=> 1,
            'segment_id'=> 2
        ]);

        DB::table('criterias')->insert([
            'criteria_name' => 'Poise and Bearing',
            'percentage' => '40',
            'event_id'=> 1,
            'segment_id'=> 2
        ]);

        DB::table('criterias')->insert([
            'criteria_name' => 'Audience Impact',
            'percentage' => '15',
            'event_id'=> 1,
            'segment_id'=> 2
        ]);
    }
}
