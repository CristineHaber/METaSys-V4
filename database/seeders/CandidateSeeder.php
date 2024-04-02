<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('candidates')->insert([
            'candidate_name' => 'Cristine Haber',
            'candidate_number' => '1',
            'candidate_address' => 'Ombao Polpog',
            'event_id'=> 1
        ]);

        DB::table('candidates')->insert([
            'candidate_name' => 'Kaye Romero',
            'candidate_number' => '2',
            'candidate_address' => 'Inapatan',
            'event_id'=> 1
        ]);

        DB::table('candidates')->insert([
            'candidate_name' => 'Rommel Ramos',
            'candidate_number' => '3',
            'candidate_address' => 'San Roque',
            'event_id'=> 1
        ]);

        DB::table('candidates')->insert([
            'candidate_name' => 'Edilyn Jornala',
            'candidate_number' => '4',
            'candidate_address' => 'San sana',
            'event_id'=> 1
        ]);

        DB::table('candidates')->insert([
            'candidate_name' => 'Cristine Haber',
            'candidate_number' => '1',
            'candidate_address' => 'Ombao Polpog',
            'event_id'=> 2
        ]);

        DB::table('candidates')->insert([
            'candidate_name' => 'Kaye Romero',
            'candidate_number' => '2',
            'candidate_address' => 'Inapatan',
            'event_id'=> 2
        ]);

        DB::table('candidates')->insert([
            'candidate_name' => 'Rommel Ramos',
            'candidate_number' => '3',
            'candidate_address' => 'San Roque',
            'event_id'=> 2
        ]);

        DB::table('candidates')->insert([
            'candidate_name' => 'Edilyn Jornala',
            'candidate_number' => '4',
            'candidate_address' => 'San sana',
            'event_id'=> 2
        ]);
    }
}
