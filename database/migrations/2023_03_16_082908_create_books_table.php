<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('collection');
            $table->string('ISBN');
            $table->date('publication_date');
            $table->integer('number_of_pages');
            $table->string('physical_place');
            $table->text('content');
<<<<<<< HEAD
            $table->unsignedBigInteger('genre_id');
            $table->unsignedBigInteger('status_id');
            $table->foreign('genre_id')->references('id')->on("genres")->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('status_id')->references('id')->on("statuses")->onDelete('cascade')->onUpdate('cascade');
=======
            $table->foreignId('genre_id')->references('id')->on('genres');
            $table->foreignId('statut_id')->references('id')->on('statues');
>>>>>>> aefc77d0a400f8ec1854a3e0d13e0fcf39460205
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
