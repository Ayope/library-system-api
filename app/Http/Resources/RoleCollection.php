<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RoleCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */

    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return [
                'name' => $item->name,
                'permissions' => $item->permissions
            ];
        });
    }

}
