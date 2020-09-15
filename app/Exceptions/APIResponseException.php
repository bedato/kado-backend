<?php

namespace App\Exceptions;

use Illuminate\Http\Exceptions\HttpResponseException;

class APIResponseException extends HttpResponseException
{
    /**
     * Get the underlying response instance.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getResponse()
    {
        $errors = $this->response->getData();

        $this->response = [
            'data' => [],
            'success' => false,
            'meta' => [
                'results' => 0
            ],
        ];

        $this->response['errors'] = $errors->errors;

        return $this->response;
    }
}
