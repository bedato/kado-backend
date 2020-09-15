<?php

declare(strict_types=1);

namespace App\Infrastructure\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\APIResponseException;

abstract class JsonRequest extends FormRequest
{

    /**
     * Get the validator instance for the request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * If validator fails return the exception in json form
     *
     * @param Validator $validator - Validator instance
     *
     * @return array
     */
    protected function failedValidation(Validator $validator)
    {
        throw new APIResponseException(
            response()->json(['errors' => $validator->errors()])
        );
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    protected function rules()
    {
        return [
            'per_page' => ['nullable', 'integer'],
            'from' => ['nullable', 'integer'],
            'sort_by' => ['nullable', 'string'],
            'sort_rule' => ['nullable', 'string'],
            'random' => ['nullable', 'integer'],
            'page' => ['nullable', 'integer']
        ];
    }

    /**
     * Get the validated data from the request.
     *
     * @return array
     */
    public function validated()
    {
        $extraAttributes = array_diff_key($this->request->all(), $this->rules());

        if (!empty($extraAttributes)) {
            foreach ($extraAttributes as $attribute => $value) {
                $this->validator->addFailure($attribute, 'forbidden_attribute', ['value' => $value]);
            }

            $this->failedValidation($this->validator);
        }

        return $this->validator->validated();
    }
}
