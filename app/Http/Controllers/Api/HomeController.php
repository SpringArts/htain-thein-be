<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\UseCases\HomeAction\HomeAction;

class HomeController extends Controller
{
    private $overviewData = [];

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

    public function storeContactInfo(Request $request): JsonResponse
    {
        $formData = $request->safe()->all();
        $storeData = $this->overviewData->storeContactInfo($formData);
        return ResponseHelper::success('Successfully Submitted', null, 201);
    }
}
