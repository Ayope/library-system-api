<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('genres')->insert([
            ['name' => 'Romance'],
            ['name' => 'Mystery'],
            ['name' => 'Science Fiction'],
            ['name' => 'Fantasy'],
            ['name' => 'Horror'],
            ['name' => 'Thriller'],
            ['name' => 'Historical Fiction'],
            ['name' => 'Young Adult'],
            ['name' => 'Contemporary'],
            ['name' => 'Literary Fiction'],
            ['name' => 'Crime'],
            ['name' => 'Historical Non-Fiction'],
            ['name' => 'Memoir'],
            ['name' => 'Humor'],
            ['name' => 'Self-Help'],
            ['name' => 'Cooking'],
            ['name' => 'Travel'],
            ['name' => 'Science'],
            ['name' => 'Business']
        ]);
    }
}
