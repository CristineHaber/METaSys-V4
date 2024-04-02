<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JudgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $judgeName = 'Melemmel';
        $username = $this->generateUserName($judgeName);

        $user = User::create([
            'name' => $judgeName,
            'username' => $username,
            'password' => Hash::make($judgeName),
            'usertype' => 'judge',
        ]);
        DB::table('judges')->insert([
            'judge_name' => $judgeName,
            'is_chairman' => 1,
            'event_id' => 1,
            'user_id' => $user->id,
        ]);

        // Create another user and insert data into the judges table
        $judgeName = 'Jorel Agustin';
        $username = $this->generateUserName($judgeName);

        $user = User::create([
            'name' => $judgeName,
            'username' => $username,
            'password' => Hash::make($judgeName),
            'usertype' => 'judge',
        ]);

        DB::table('judges')->insert([
            'judge_name' => $judgeName,
            'is_chairman' => 0,
            'event_id' => 1,
            'user_id' => $user->id,
        ]);

        $judgeName = 'Cristine Haber';
        $username = $this->generateUserName($judgeName);

        $user = User::create([
            'name' => $judgeName,
            'username' => $username,
            'password' => Hash::make($judgeName),
            'usertype' => 'judge',
        ]);
        DB::table('judges')->insert([
            'judge_name' => $judgeName,
            'is_chairman' => 1,
            'event_id' => 1,
            'user_id' => $user->id,
        ]);
    }
    public function generateUserName($name)
    {
        // Generate a random username
        $randomUsername = Str::lower(Str::random(8)); // You can adjust the length of the random string as needed
        if (User::where('username', '=', $randomUsername)->exists()) {
            // If the random username already exists, generate a new one recursively
            return $this->generateUserName($name);
        }
        return $randomUsername;
    }
}
