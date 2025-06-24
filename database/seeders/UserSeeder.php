<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'user_id' => (string) Str::uuid(),
            'name' => 'John',
            'email' => 'john@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role' => 'Admin',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'user_id' => (string) Str::uuid(),
            'name' => 'jane',
            'email' => 'jane@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role' => 'Dosen',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'user_id' => (string) Str::uuid(),
            'name' => 'Himakom',
            'email' => 'Himakom@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role' => 'Himpunan',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'user_id' => (string) Str::uuid(),
            'name' => 'Sulthan',
            'email' => 'Sulthan@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role' => 'Sulthan',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
