<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Infrastructure\Resources\WithApiWrapping;
use App\Infrastructure\Resources\WithDataFormatters;
use Illuminate\Http\Resources\Json\JsonResource;

class ShapeResource extends JsonResource
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
        $shape = $this->resource;

        return [
            'id' => (int) $shape->id,
            'shape' => $shape->shape,
            'created_at' => $this->formatDate($shape->created_at),
            'updated_at' => $this->formatDate($shape->updated_at)
        ];
    }
}
