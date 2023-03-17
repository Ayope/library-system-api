<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Statut;
use Carbon\Carbon;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */

 class BookFactory extends Factory
 {
     protected $model = Book::class;

     public function definition()
     {
        $statues = Statut::all()->pluck('id')->toArray();
        $genres = Genre::all()->pluck('id')->toArray();

         return [
            'title' => $this->faker->sentence(4),
            'author' => $this->faker->name,
            'collection' => $this->faker->word,
            'ISBN' => $this->faker->isbn13,
            'publication_date' => Carbon::now()->subYears(5),
            'number_of_pages' => $this->faker->numberBetween(100, 500),
            'physical_place' => $this->faker->word,
            'content' => $this->faker->paragraph(10),
            'genre_id' => $this->faker->randomElement($genres),
            'statut_id' => $this->faker->randomElement($statues),
        ];
     }
 }
