<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Infrastructure\Requests\JsonRequest;

class CreateOutfitRequest extends JsonRequest
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
            'item_id' => ['integer'],
        ];
    }
}
