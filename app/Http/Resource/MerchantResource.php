<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Infrastructure\Resources\WithApiWrapping;
use App\Infrastructure\Resources\WithDataFormatters;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Lang;

class MerchantResource extends JsonResource
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
        $merchant = $this->resource;

        $deletedAt = $merchant->deleted_at ? $this->formatDate($merchant->deleted_at) : null;

        return [
            'email' => $merchant->email,
            'password' => Lang::get('messages.redacted'),
            'api_token' => $merchant->api_token,
            'remember_token' => $merchant->remember_token,
            'created_at' => $this->formatDate($merchant->created_at),
            'updated_at' => $this->formatDate($merchant->updated_at),
            'deleted_at' => $deletedAt
        ];
    }
}
