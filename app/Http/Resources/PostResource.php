<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Infrastructure\Resources\WithApiWrapping;
use App\Infrastructure\Resources\WithDataFormatters;
use App\Http\Resources\OutfitResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    use WithApiWrapping, WithDataFormatters;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request - incoming request
     *
     * @return array
     **/
    public function toArray($request)
    {
        $post = $this->resource;

        return [
            'id' => $post->id,
            'outfit_id' => (int) $post->outfit_id,
            'user_id' => (int) $post->user_id,
            'outfit' => new OutfitResource($post->outfit),
            'created_at' => $this->formatDate($post->created_at)
        ];
    }
}
