<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use App\Http\Resources\GenreResource;
use App\Http\Resources\GenreCollection;

class GenreController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_genres', ['only' => ['index']]);
        $this->middleware('permission:genre_create', ['only' => ['store']]);
        $this->middleware('permission:genre_edit', ['only' => ['update']]);
        $this->middleware('permission:genre_show', ['only' => ['show']]);
        $this->middleware('permission:genre_delete', ['only' => ['destroy']]);
        $this->middleware('permission:genre_filter', ['only' => ['filterByGenre']]);
    }

    public function index()
    {
        $genres = Genre::all();
        return new GenreCollection($genres);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $genre = Genre::create([
            'name' => $request->name,
        ]);

        return new GenreResource($genre);
    }

    public function show(Genre $genre)
    {
        return new GenreResource($genre);
    }

    public function update(Request $request, Genre $genre)
    {
        $genre->update([
            'name' => $request->name,
        ]);

        return new GenreResource($genre);
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();
        return response()->json([
            'message' => 'successfully deleted'
        ]);
    }

    public function filterByGenre($genre_id){
        $genre = Genre::with('books')->where('id', $genre_id)->first();

        if(!$genre){
            return response()->json([
                'error' => 'genre not found!'
            ], 404);
        }

        return response()->json([
            'books associated with ' . $genre->name => $genre->books
        ]);
    }
}

