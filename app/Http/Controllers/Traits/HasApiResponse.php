<?php

namespace App\Http\Controllers\Traits;

use App\Http\Controllers\Api\AuthController;

trait HasApiResponse
{

    public function error(string $message, int $status)
    {
        return $this->apiResponse($message, [], $status);
    }

    public function apiResponse(string $message, array $data = [], int $status = 200)
    {
        return response()->json([
            'message' => $message,
            'data' => $data
        ], $status);
    }

    public function ok(string $message, array $data = [], int $status = 200)
    {
        return $this->apiResponse($message, $data, $status);
    }
}
