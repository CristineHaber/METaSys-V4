<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('events')->insert([
            'user_id' => 1,
            'event_name' => 'Mr and Ms CCS',
            'event_date' => now(),
            'start_time' => now(),
            'end_time' => '8:05', // Enclosed in quotes
            'event_place' => 'Nabua, Camarines Sur'
        ]);
        

        DB::table('events')->insert([
            'user_id' => 1,
            'event_name' => 'Ms. Iriga',
            'event_date' => now(),
            'start_time' => now(),
            'end_time' => '8:10', // Enclosed in quotes
            'event_place'=> 'Iriga City, Camarines Sur'
        ]);

        DB::table('events')->insert([
            'user_id' => 1,
            'event_name' => 'Mr. Masarig',
            'event_date' => now(),
            'start_time' => now(),
            'end_time' => '8:15', // Enclosed in quotes
            'event_place'=> 'Bula, Camarines Sur'
        ]);
        
        // DB::table('events')->insert([
        //     'user_id' => 1,
        //     'event_name' => 'Ms. Iriga',
        //     'event_date' => now(),
        //     'start_time' => now(),
        //     'end_time' => '8:25', // Enclosed in quotes
        //     'event_place'=> 'Iriga City, Camarines Sur'
        // ]);

        // DB::table('events')->insert([
        //     'user_id' => 1,
        //     'event_name' => 'Mr and Ms Intrams CSPC',
        //     'event_date' => now(),
        //     'start_time' => now(),
        //     'end_time' => '8:15', // Enclosed in quotes
        //     'event_place'=> 'Nabua, Camarines Sur'
        // ]);
    }
}
