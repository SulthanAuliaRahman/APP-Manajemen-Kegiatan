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
            'name' => 'admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role' => 'admin',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'user_id' => (string) Str::uuid(),
            'name' => 'dosen',
            'email' => 'dosen@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role' => 'dosen',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'user_id' => (string) Str::uuid(),
            'name' => 'himpunan',
            'email' => 'himpunan@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role' => 'himpunan',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'user_id' => (string) Str::uuid(),
            'name' => 'mahasiswa',
            'email' => 'mahasiswa@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role' => 'mahasiswa',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
