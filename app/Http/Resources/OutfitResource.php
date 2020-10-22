<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Infrastructure\Resources\WithApiWrapping;
use App\Infrastructure\Resources\WithDataFormatters;
use Illuminate\Http\Resources\Json\JsonResource;

class OutfitResource extends JsonResource
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
        $outfit = $this->resource;

        return [
            'id' => (int) $outfit->id,
            'user_id' => (int) $outfit->user_id,
            'items' => $outfit->items,
            'created_at' => $this->formatDate($outfit->created_at),
            'updated_at' => $this->formatDate($outfit->updated_at)
        ];
    }
}
