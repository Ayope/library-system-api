<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BookCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->collection->map(function ($item) {
            return [
                'title' => $item->title,
                'author' => $item->author,
                'collection' => $item->collection,
                'ISBN' => $item->ISBN,
                'publication_date' => $item->publication_date,
                'number_of_pages' => $item->number_of_pages,
                'physical_place' => $item->physical_place,
                'content' => $item->content,
                'genre' => $item->genre->name,
                'status' => $item->status->name,
            ];
        });
    }
}
