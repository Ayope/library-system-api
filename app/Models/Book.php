<?php

namespace App\Models;

use App\Models\Genre;
use App\Models\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'collection',
        'ISBN',
        'publication_date',
        'number_of_pages',
        'physical_place',
        'content',
        'genre_id',
        'status_id'
    ];

    function genre(){
        return $this->belongsTo(Genre::class);
    }

    function status(){
        return $this->belongsTo(Status::class);
    }
}
