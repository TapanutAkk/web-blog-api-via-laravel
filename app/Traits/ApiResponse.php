<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected function success(mixed $result, string $message = 'Success.', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'status_code' => $statusCode,
            'result' => $result,
            'message' => $message,
        ], 200);
    }

    protected function error(string $message, int $statusCode = 400): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'status_code' => $statusCode,
            'result' => null,
            'message' => $message,
        ], 200);
    }
}
