<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookCollection;

class BookController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        $books = Book::with('genre', 'status')->get();
        return new BookCollection($books);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'collection' => 'required',
            'ISBN' => 'required',
            'publication_date' => 'required',
            'number_of_pages' => 'required',
            'physical_place' => 'required',
            'content' => 'required',
            'genre_id' => 'required',
            'status_id' => 'required',
        ]);

        $book = Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'collection' => $request->collection,
            'ISBN' => $request->ISBN,
            'publication_date' => $request->publication_date,
            'number_of_pages' => $request->number_of_pages,
            'physical_place' => $request->physical_place,
            'content' => $request->content,
            'genre_id' => $request->genre_id,
            'status_id' => $request->status_id,
        ]);

        return new BookResource($book);
    }

    public function show(Book $book)
    {
        // $book = Book::with('genre', 'status')->where('id', $book->id)->get();
        return new BookResource($book);
    }

    public function update(Request $request, Book $book)
    {
        $book->update([
            'title' => $request->title,
            'author' => $request->author,
            'collection' => $request->collection,
            'ISBN' => $request->ISBN,
            'publication_date' => $request->publication_date,
            'number_of_pages' => $request->number_of_pages,
            'physical_place' => $request->physical_place,
            'content' => $request->content,
            'genre_id' => $request->genre_id,
            'status_id' => $request->status_id,
        ]);

        return new BookResource($book);
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json([
            'message' => 'successfully deleted'
        ]);
    }

}
