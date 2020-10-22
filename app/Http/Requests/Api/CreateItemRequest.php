<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Infrastructure\Requests\JsonRequest;

class CreateItemRequest extends JsonRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => ['integer'],
            'category' => ['nullable', 'string'],
            'category_id' => ['nullable', 'integer'],
            'season' => ['nullable', 'string'],
            'color' => ['nullable', 'string'],
            'style' => ['nullable', 'string'],
            'shape' => ['nullable', 'string']
        ];
    }
}
