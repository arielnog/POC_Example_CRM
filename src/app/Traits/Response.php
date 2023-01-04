<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use stdClass;
use Throwable;

trait Response
{
    /**
     * @param array $resource
     * @param string|null $message
     * @param int $statusCode
     * @param array $headers
     * @return JsonResponse
     */
    protected function responseWithArray(
        array $resource,
        string $message = null,
        int $statusCode = 200,
        array $headers = []
    ): JsonResponse {
        return $this->apiResponse(
            [
                'success' => true,
                'message' => $message,
                'data' => $resource,
            ],
            $statusCode,
            $headers
        );
    }

    /**
     * @param array $data
     * @param int $statusCode
     * @param array $headers
     * @return array
     */
    public function parseGivenData(
        array $data = [],
        int $statusCode = 200,
        array $headers = []
    ): array {
        $responseStructure = [
            'success' => $data['success'],
            'message' => $data['message'] ?? '',
            'data' => $data['data'] ?? new stdClass,
        ];

        if (isset($data['exception'])) {
            $responseStructure['errors'] = $data['exception'];
        }
        if (isset($data['status'])) {
            $statusCode = $data['status'];
        }

        return ["content" => $responseStructure, "statusCode" => $statusCode, "headers" => $headers];
    }

    /**
     * Return generic json response with the given data.
     *
     * @param array $data
     * @param int $statusCode
     * @param array $headers
     *
     * @return JsonResponse
     */
    protected function apiResponse(
        array $data = [],
        int $statusCode = 200,
        array $headers = []
    ): JsonResponse {
        $result = $this->parseGivenData($data, $statusCode, $headers);

        return response()->json(
            $result['content'],
            $result['statusCode'],
            $result['headers']
        );
    }

    /**
     * @param Collection $resourceCollection
     * @param string|null $message
     * @param int $statusCode
     * @param array $headers
     * @return JsonResponse
     */
    protected function responseWithResourceCollection(
        Collection $resourceCollection,
        string $message = null,
        int $statusCode = 200,
        array $headers = []
    ): JsonResponse {
        return $this->apiResponse(
            [
                'success' => true,
                'message' => $message,
                'data' => $resourceCollection->toArray()
            ],
            $statusCode,
            $headers
        );
    }

    /**
     * Respond with success.
     *
     * @param $resource
     * @param string|null $message
     * @param int $statusCode
     * @param array $headers
     * @return JsonResponse
     */
    protected function responseSuccess(
        $resource,
        string $message = null,
        int $statusCode = 200,
        array $headers = []
    ): JsonResponse {
        if (is_array($resource)) {
            return $this->responseWithArray($resource, $message, $statusCode, $headers);
        } else {
            if ($resource instanceof Collection) {
                return $this->responseWithResourceCollection($resource, $message, $statusCode, $headers);
            } else {
                if (is_array($resource) && array_key_exists('data', $resource)) {
                    $data = $resource;

                    return $this->apiResponse(
                        [
                            'success' => true,
                            'message' => $message,
                            'data' => $data
                        ],
                        $statusCode,
                        $headers
                    );
                } else {
                    return $this->apiResponse(['success' => true, 'message' => $message], $statusCode, $headers);
                }
            }
        }
    }

    /**
     * Respond with created.
     *
     * @param null $resource
     * @return JsonResponse
     */
    protected function responseCreated($resource = null): JsonResponse
    {
        $message = $message ?? 'Created.';
        if (!empty($resource)) {
            return $this->responseSuccess($resource, $message, 201);
        }
        return $this->apiResponse(['success' => true, 'message' => $message], 201);
    }

    /**
     * Respond with no content.
     *
     * @param string|null $message
     *
     * @return JsonResponse
     */
    protected function responseNoContent(string $message = null): JsonResponse
    {
        $message = $message ?? 'No content.';
        return $this->apiResponse(['success' => false, 'message' => $message], 204);
    }

    /**
     * Respond with no content.
     *
     * @param string|null $message
     *
     * @return JsonResponse
     */
    protected function responseNoContentResource(string $message = null): JsonResponse
    {
        $message = $message ?? 'No content.';
        return $this->responseWithArray(array(), $message);
    }

    /**
     * Respond with no content.
     *
     * @param string|null $message
     *
     * @return JsonResponse
     */
    protected function resonseNoContentResourceCollection(string $message = null): JsonResponse
    {
        $message = $message ?? 'No content.';
        return $this->responseWithResourceCollection(new Collection([]), $message);
    }

    /**
     * Respond with unauthorized.
     *
     * @param string|null $message
     *
     * @return JsonResponse
     */
    protected function responseUnauthorized(string $message = null): JsonResponse
    {
        $message = $message ?? 'Unauthorized.';
        return $this->responseError($message, 401);
    }

    /**
     * Respond with error.
     *
     * @param string $message
     * @param int $statusCode
     *
     * @param Exception|null $exception
     * @param int $error_code
     * @return JsonResponse
     */
    protected function responseError(
        string $message,
        int $statusCode = 400,
        Throwable $exception = null,
        int $error_code = 1
    ): JsonResponse {
        $message = $message ?? 'Bad request.';
        return $this->apiResponse(
            [
                'success' => false,
                'message' => $message,
                'exception' => [
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => $exception->getTraceAsString(),
                ],
                'error_code' => $error_code
            ],
            $statusCode
        );
    }

    /**
     * Respond with forbidden.
     *
     * @param string|null $message
     *
     * @return JsonResponse
     */
    protected function responseForbidden(string $message = null): JsonResponse
    {
        $message = $message ?? 'Forbidden.';
        return $this->responseError($message, 403);
    }

    /**
     * Respond with not found.
     *
     * @param string|null $message
     *
     * @return JsonResponse
     */
    protected function responseNotFound(string $message = null): JsonResponse
    {
        $message = $message ?? 'Not found.';
        return $this->responseError($message, 404);
    }

    /**
     * Respond with internal error.
     *
     * @param null $exception
     * @param string|null $message
     *
     * @return JsonResponse
     */
    protected function responseInternalError(
        $exception = null,
        string $message = null,
        int $code = 500
    ): JsonResponse {
        $message = $message ?? 'Internal server error.';
        $exceptionMessage = $exception->getMessage();
        $message = (!empty($exceptionMessage)) ? $exceptionMessage : $message;
        return $this->responseError($message, $code, $exception);
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
