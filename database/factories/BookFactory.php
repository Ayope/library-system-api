<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Status;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */

 class BookFactory extends Factory
 {
     protected $model = Book::class;

     public function definition()
     {

         return [
            'title' => $this->faker->sentence(4),
            'author' => $this->faker->name,
            'collection' => $this->faker->word,
            'ISBN' => $this->faker->isbn13,
            'publication_date' => Carbon::now()->subYears(5),
            'number_of_pages' => $this->faker->numberBetween(100, 500),
            'physical_place' => $this->faker->word,
            'content' => $this->faker->paragraph(10),
            'genre_id' => fake()->numberBetween(Genre::min('id'),Genre::max('id')),
            'status_id' => fake()->numberBetween(Status::min('id'),Status::max('id')),
        ];
     }
 }
