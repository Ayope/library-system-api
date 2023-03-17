<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('statuses')->insert([
        [
            'name' => 'emprunté'
        ],
        [
            'name' => 'disponible'
        ],
        [
            'name' => 'entraitement'
        ]
    ]);
    }
}

