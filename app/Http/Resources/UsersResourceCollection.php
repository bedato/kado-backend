<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Infrastructure\Resources\WithApiWrapping;
use App\Infrastructure\Resources\WithDataFormatters;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserResourcesCollection extends ResourceCollection
{
    use WithApiWrapping, WithDataFormatters;

    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request - incoming request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
