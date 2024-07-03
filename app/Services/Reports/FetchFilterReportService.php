<?php

namespace App\Services\Reports;

use App\Helpers\ResponseHelper;
use App\Http\Resources\ReportResource;
use App\Interfaces\Report\ReportInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FetchFilterReportService
{
    public function __invoke(ReportInterface $reportRepository, array $validatedData): JsonResponse
    {
        try {
            $data = $reportRepository->reportFilter($validatedData);
            $meta = ResponseHelper::getPaginationMeta($data);
            return response()->json([
                'data' => ReportResource::collection($data),
                'meta' => $meta,
            ]);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
