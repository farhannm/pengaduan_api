<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            'id' => 1,
            'role' => 'admin'
        ]);

        DB::table('roles')->insert([
            'id' => 2,
            'role' => 'petugas'
        ]);

        DB::table('roles')->insert([
            'id' => 3,
            'role' => 'user'
        ]);
    }
}
