<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('category')->insert([
            'name' => "Men's Fashion"
        ]);

        DB::table('category')->insert([
            'name' => "Women's Fashion"
        ]);

        DB::table('category')->insert([
            'name' => "Stationery"
        ]);

        DB::table('category')->insert([
            'name' => "Gadgets"
        ]);

        DB::table('category')->insert([
            'name' => "Sport Equipment"
        ]);
        
        DB::table('category')->insert([
            'name' => "Books"
        ]);

        DB::table('category')->insert([
            'name' => "Services"
        ]);
    }
}
