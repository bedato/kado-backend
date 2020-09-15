<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Infrastructure\Requests\JsonRequest;
use Lang;

class CreateUserRequest extends JsonRequest
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
            'user_code' => ['required', 'unique:users,user_code']
        ];
    }

    public function messages()
    {
        return [
            'user_code.required' => Lang::get('validation.user_code_required')
        ];
    }
}
