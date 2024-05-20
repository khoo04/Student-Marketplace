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
        DB::table('categories')->insert([
            'name' => "Men's Fashion"
        ]);

        DB::table('categories')->insert([
            'name' => "Women's Fashion"
        ]);

        DB::table('categories')->insert([
            'name' => "Stationery"
        ]);

        DB::table('categories')->insert([
            'name' => "Gadgets"
        ]);

        DB::table('categories')->insert([
            'name' => "Sport Equipment"
        ]);
        
        DB::table('categories')->insert([
            'name' => "Books"
        ]);

        DB::table('categories')->insert([
            'name' => "Services"
        ]);
    }
}
