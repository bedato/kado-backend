<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Infrastructure\Requests\JsonRequest;
use Lang;

class CreatePostRequest extends JsonRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     **/
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     **/
    public function rules()
    {
        return [
            'outfit_id' => ['required', 'integer']
        ];
    }

    /**
     * Custom messages to be returned.
     *
     * @return array
     **/
    public function messages()
    {
        return [
            'outfit.required' => Lang::get('validation.outfit_id_required')
        ];
    }
}
