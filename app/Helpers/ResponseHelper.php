<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;


class ResponseHelper
{
    public static function success($message, $data = null, $status = 200, $alertVisible = 1)
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

    public static function fail($message, $data = null, $status = 502, $alertVisible = 1)
    {
        return response()->json(
            [
                'alertVisible' => $alertVisible,
                'error' => $message,
            ],
            $status
        );
    }

    public static function getPaginationMeta(LengthAwarePaginator $data)
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
