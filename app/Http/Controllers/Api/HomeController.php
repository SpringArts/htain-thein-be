<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\UseCases\HomeAction\HomeAction;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    private HomeAction $overviewData;

    public function __construct(HomeAction $overviewData)
    {
        $this->overviewData = $overviewData;
    }

    public function dashboard(): JsonResponse
    {
        $data = $this->overviewData->fetchData();

        return response()->json([
            'data' => $data,
        ]);
    }
}
