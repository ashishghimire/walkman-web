<?php

namespace App\Http\Controllers;

use Response;
use Illuminate\Http\Response as IlluminateResponse;

class ApiController extends Controller
{
	protected $statusCode = 200;

	public function getStatusCode()
	{
		return $this->statusCode;
	}

	public function setStatusCode($statusCode)
	{
		$this->statusCode = $statusCode;

		return $this;
	}

	public function respondNotFound($message = 'Not Found!')
	{
		return $this->setStatusCode(404)->respondWithError($message);
	}

	public function respondInternalError($message = 'InternalError!')
	{
		return $this->setStatusCode(500)->respondWithError($message);
	}

	public function respondParameterFailed($message = 'Parameters Failed')
	{
		return $this->setStatusCode(422)->respondWithError($message);
	}

	public function respondUpdated($message = 'Successfully Updated')
    {
        return $this->setStatusCode(201)->respond([
            'message' => $message,
        ]);
    }

	public function respond($data, $headers = [])
	{
		return Response::json($data, $this->getStatusCode(), $headers);
	}

	public function respondWithError($message)
	{
		return $this->respond([
			'error' => [
				'message' => $message,
				'status_code' => $this->getStatusCode()
			]
		]);
	}
	public function respondCreated($message, $apiToken)
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_CREATED)->respond([
            'message' => $message,
            'api_token' => $apiToken,
        ]);
    }
}