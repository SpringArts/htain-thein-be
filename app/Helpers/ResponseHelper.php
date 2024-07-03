<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class ResponseHelper
{
    public static function success(string $message, mixed $data = null, int $status = 200, int $alertVisible = 1): JsonResponse
    {
        return response()->json(
            [
                'alertVisible' => $alertVisible,
                'msg' => $message,
                'data' => $data,
            ],
            $status
        );
    }

    public static function fail(string $message, int $status = 502, int $alertVisible = 1): JsonResponse
    {
        return response()->json(
            [
                'alertVisible' => $alertVisible,
                'error' => $message,
            ],
            $status
        );
    }

    public static function getPaginationMeta(LengthAwarePaginator $data): array
    {
        return [
            'currentPage' => $data->currentPage(),
            'totalPages' => $data->lastPage(),
            'startOffset' => $data->firstItem(),
            'endOffset' => $data->lastItem(),
            'totalItems' => $data->total(),
        ];
    }
}
