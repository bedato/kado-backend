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
            'winterjacket_id' => $outfit->winterjacket_id,
            'jacket_id' => $outfit->jacket_id,
            'top_id' => $outfit->top_id,
            'bottom_id' => $outfit->bottom_id,
            'image_url' => $outfit->image_url,
            'season' => $outfit->season,
            'style' => $outfit->style,
            'created_at' => $this->formatDate($outfit->created_at),
            'updated_at' => $this->formatDate($outfit->updated_at)
        ];
    }
}
