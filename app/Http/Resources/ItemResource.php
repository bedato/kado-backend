<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Infrastructure\Resources\WithApiWrapping;
use App\Infrastructure\Resources\WithDataFormatters;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
        $item = $this->resource;

        return [
            'id' => (int) $item->id,
            'category' => $item->category,
            'season' => $item->season,
            'created_at' => $this->formatDate($item->created_at),
            'updated_at' => $this->formatDate($item->updated_at)
        ];
    }
}
