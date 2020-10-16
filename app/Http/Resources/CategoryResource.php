<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Infrastructure\Resources\WithApiWrapping;
use App\Infrastructure\Resources\WithDataFormatters;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    use WithApiWrapping, WithDataFormatters;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $category = $this->resource;

        return [
            'id' => (int) $category->id,
            'category' => $category->category,
            'created_at' => $this->formatDate($category->created_at),
            'updated_at' => $this->formatDate($category->updated_at)
        ];
    }
}
