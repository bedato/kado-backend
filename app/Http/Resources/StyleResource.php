<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Infrastructure\Resources\WithApiWrapping;
use App\Infrastructure\Resources\WithDataFormatters;
use Illuminate\Http\Resources\Json\JsonResource;

class StyleResource extends JsonResource
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
        $style = $this->resource;

        return [
            'id' => (int) $style->id,
            'style' => $style->style,
            'created_at' => $this->formatDate($style->created_at),
            'updated_at' => $this->formatDate($style->updated_at)
        ];
    }
}
