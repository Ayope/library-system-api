<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'author' => $this->author,
            'collection' => $this->collection,
            'ISBN' => $this->ISBN,
            'publication_date' => $this->publication_date,
            'number_of_pages' => $this->number_of_pages,
            'physical_place' => $this->physical_place,
            'content' => $this->content,
            'genre' => $this->genre->name,
            'status' => $this->status->name,
        ];
    }
}
