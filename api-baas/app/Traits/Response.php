<?php

namespace App\Traits;

use Error;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Validation\ValidationException;
use stdClass;
use Throwable;

trait Response
{
    /**
     * @param JsonResource $resource
     * @param null $message
     * @param int $statusCode
     * @param array $headers
     * @return JsonResponse
     */
    protected function responseWithResource(
        JsonResource $resource, 
        $message = null, 
        $statusCode = 200, 
        $headers = []
    ) {
        return $this->apiResponse(
            [
                'success' => true,
                'data' => $resource,
                'message' => $message
            ], $statusCode, $headers
        );
    }

    /**
     * @param array $data
     * @param int $statusCode
     * @param array $headers
     * @return array
     */
    public function parseGivenData($data = [], $statusCode = 200, $headers = [])
    {
        $responseStructure = [
            'success' => $data['success'],
            'message' => $data['message'] ?? '',
            'data' => $data['data'] ?? new stdClass,
        ];
        if (isset($data['errors'])) {
            $responseStructure['errors'] = $data['errors'];
        }
        if (isset($data['status'])) {
            $statusCode = $data['status'];
        }


        // if (isset($data['exception']) && ($data['exception'] instanceof Error || $data['exception'] instanceof Exception)) {
        //     if (config('app.debug') === true) {
        //         $responseStructure['exception'] = [
        //             'message' => $data['exception']->getMessage(),
        //             'file' => $data['exception']->getFile(),
        //             'line' => $data['exception']->getLine(),
        //             'code' => $data['exception']->getCode(),
        //             'trace' => $data['exception']->getTrace(),
        //         ];
        //     }

        //     if ($statusCode === 200) {
        //         $statusCode = 500;
        //     }
        // }
        
        return ["content" => $responseStructure, "statusCode" => $statusCode, "headers" => $headers];
    }


    /*
     *
     * Just a wrapper to facilitate abstract
     */

    /**
     * Return generic json response with the given data.
     *
     * @param       $data
     * @param int $statusCode
     * @param array $headers
     *
     * @return JsonResponse
     */
    protected function apiResponse($data = [], $statusCode = 200, $headers = [])
    {
        $result = $this->parseGivenData($data, $statusCode, $headers);

        return response()->json(
            $result['content'], $result['statusCode'], $result['headers']
        );
    }

    /*
     *
     * Just a wrapper to facilitate abstract
     */

    /**
     * @param ResourceCollection $resourceCollection
     * @param null $message
     * @param int $statusCode
     * @param array $headers
     * @return JsonResponse
     */
    protected function responseWithResourceCollection(ResourceCollection $resourceCollection, $message = null, $statusCode = 200, $headers = [])
    {
        return $this->apiResponse(
            [
                'success' => true,
                'data' => $resourceCollection->response()->getData()
            ], $statusCode, $headers
        );
    }

    /**
     * Respond with success.
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function responseSuccess($resource, $message = null, $statusCode = 200, $headers = [])
    {   
        if ($resource instanceof JsonResource) {
            return $this->responseWithResource($resource, $message, $statusCode, $headers);
        }
        else if ($resource instanceof ResourceCollection) {
            return $this->responseWithResourceCollection($resource, $message, $statusCode, $headers);
        }
        else if (is_array($resource) && array_key_exists('data', $resource)) {
            $data = $resource;
            if (array_key_exists('data', $resource)) {
                $data = $resource['data'];
            }

            return $this->apiResponse(['success' => true, 'message' => $message, 'data' => $data], $statusCode, $headers);
        }
        else {
            return $this->apiResponse(['success' => true, 'message' => $message], $statusCode, $headers);
        }
    }

    /**
     * Respond with created.
     *
     * @param $data
     *
     * @return JsonResponse
     */
    protected function responseCreated($resource = null)
    {
        $message = $message ?? 'Created.';
        if (!empty($resource)) return $this->responseSuccess($resource, $message, 201);
        return $this->apiResponse(['success' => true, 'message' => $message], 201);
    }

    /**
     * Respond with no content.
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function responseNoContent($message = null)
    {
        $message = $message ?? 'No content.';
        return $this->apiResponse(['success' => false, 'message' => $message], 204);
    }

    /**
     * Respond with no content.
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function responseNoContentResource($message = null)
    {
        $message = $message ?? 'No content.';
        return $this->responseWithResource(new JsonResource([]), $message);
    }
    /**
     * Respond with no content.
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function resonseNoContentResourceCollection($message = null)
    {
        $message = $message ?? 'No content.';
        return $this->responseWithResourceCollection(new ResourceCollection([]), $message);
    }

    /**
     * Respond with unauthorized.
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function responseUnauthorized($message = null)
    {
        $message = $message ?? 'Unauthorized.';
        return $this->responseError($message, 401);
    }

    /**
     * Respond with error.
     *
     * @param $message
     * @param int $statusCode
     *
     * @param Exception|null $exception
     * @param bool|null $error_code
     * @return JsonResponse
     */
    protected function responseError(
        $message, 
        int $statusCode = 400, 
        Throwable $exception = null, 
        int $error_code = 1
    ) {
        $message = $message ?? 'Bad request.';
        return $this->apiResponse(
            [
                'success' => false,
                'message' => $message,
                'exception' => $exception,
                'error_code' => $error_code
            ], $statusCode
        );
    }

    /**
     * Respond with forbidden.
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function responseForbidden($message = null)
    {
        $message = $message ?? 'Forbidden.';
        return $this->responseError($message, 403);
    }

    /**
     * Respond with not found.
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function responseNotFound($message = null)
    {
        $message = $message ?? 'Not found.';
        return $this->responseError($message, 404);
    }

    /**
     * Respond with internal error.
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function responseInternalError($exception = null, $message = null)
    {   
        $message = $message ?? 'Internal server error.';
        $exceptionMessage = $exception->getMessage();
        $message = (!empty($exceptionMessage)) ? $exceptionMessage : $message;
        return $this->responseError($message, 500, $exception);
    }

    protected function responseValidationErrors(ValidationException $exception)
    {
        return $this->apiResponse(
            [
                'success' => false,
                'message' => 'The given data was invalid.',
                'errors' => $exception->errors()
            ],
            422
        );
    }
}