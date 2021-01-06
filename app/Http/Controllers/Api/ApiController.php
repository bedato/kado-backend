<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

/*

This Controller does not contain any used functions anymore and is probably obsolete.
@TODO Remove this controller and refactor controllers which are extending this class.

 */


class ApiController extends Controller
{
    /**
     * @var int
     */
    protected $statusCode = 200;

    public function getApiToken(Request $request)
    {
        $data = [
            'message' => 'success',
            'status_code' => $this->getStatusCode(),
            'data' => ['api_token' => Auth::guard('web')->user()->api_token]
        ];

        return $this->setStatusCode(200)->respond($data);
    }

    /**
     * @param $statusCode
     *
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithError($message)
    {
        return $this->respond(
            [
                'error' => $message,
                'status_code' => $this->getStatusCode()
            ]
        );
    }

    /**
     * @param       $data
     * @param array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data, $headers = [])
    {
        $statusCode = $this->getStatusCode();

        return Response::json($data, $statusCode, $headers);
    }

    /**
     * @param string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondNotFound($message = 'Not Found!')
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }

    /**
     * @param $requiredParameters
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkMissingParams($params, $requiredParameters)
    {
        $missingParameters = [];

        foreach ($requiredParameters as $parameter) {
            if (!array_key_exists($parameter, $params)) {
                $missingParameters[] = $parameter;
            }
        }

        if (!empty($missingParameters)) {
            $missingParametersString = implode(',', $missingParameters);

            $errorMessage = 'Missing required parameters: ' . $missingParametersString;

            return $this->setStatusCode(422)->respondWithError($errorMessage);
        }
    }
}
