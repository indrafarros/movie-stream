<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('packages')->insert([
            [
                'name' => 'standar',
                'price' => 40000,
                'max_days' => 30,
                'max_users' => 2,
                'is_download' => 1,
                'is_4k' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'gold',
                'price' => 90000,
                'max_days' => 60,
                'max_users' => 4,
                'is_download' => 1,
                'is_4k' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
