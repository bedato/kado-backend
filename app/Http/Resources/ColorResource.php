<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Infrastructure\Resources\WithApiWrapping;
use App\Infrastructure\Resources\WithDataFormatters;
use Illuminate\Http\Resources\Json\JsonResource;

class ColorResource extends JsonResource
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
        $color = $this->resource;

        return [
            'id' => (int) $color->id,
            'color' => $color->color,
            'created_at' => $this->formatDate($color->created_at),
            'updated_at' => $this->formatDate($color->updated_at)
        ];
    }
}
