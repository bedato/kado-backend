<?php

declare (strict_types = 1);

namespace App\Http\Resources;

use App\Infrastructure\Resources\WithApiWrapping;
use App\Infrastructure\Resources\WithDataFormatters;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    use WithApiWrapping, WithDataFormatters;

    /**
     * Transform the resource into an array.
     *
     * @param $request - incoming request
     *
     * @return array
     */
    public function toArray($request): array
    {
        $user = $this->resource;

        $deletedAt = $user->deleted_at ? $this->formatDate($user->deleted_at) : null;

        return [
            'user_id' => $user->id,
            'user_code' => $user->user_code,
            'username' => $user->username,
            'password' => $user->password,
            'email' => $user->email,
            'items' => $user->items,
            'outfits' => $user->outfits,
            'created_at' => $this->formatDate($user->created_at),
            'updated_at' => $this->formatDate($user->updated_at),
            'deleted_at' => $deletedAt,
        ];
    }
}
