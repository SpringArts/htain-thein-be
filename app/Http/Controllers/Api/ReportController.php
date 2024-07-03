<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\App\Report\FetchReportFilterRequest;
use App\Http\Requests\V1\App\Report\StoreReportRequest;
use App\Http\Requests\V1\App\Report\UncheckReportRequest;
use App\Http\Requests\V1\App\Report\UpdateReportRequest;
use App\Http\Resources\ReportResource;
use App\Models\Report;
use App\UseCases\Report\ReportAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class ReportController extends Controller
{
    private ReportAction $reportAction;

    public function __construct(ReportAction $reportAction)
    {
        $this->reportAction = $reportAction;
    }

    public function index(FetchReportFilterRequest $request): JsonResponse
    {
        $validatedData = $request->safe()->all();
        return $this->reportAction->fetchFilterData($validatedData);
    }

    public function store(StoreReportRequest $request): JsonResponse
    {
        $formData = $request->safe()->all();
        return $this->reportAction->createReport($formData);
    }


    public function show(Report $report): JsonResponse
    {
        return response()->json([
            'data' => new ReportResource($report),
        ]);
    }

    public function update(UpdateReportRequest $request, Report $report): JsonResponse
    {
        $formData = $request->safe()->all();
        return $this->reportAction->updateReport($formData, $report);
    }

    public function uncheckReport(UncheckReportRequest $request): JsonResponse
    {
        $validatedData = $request->safe()->all();
        return $this->reportAction->uncheckReport($validatedData);
    }

    public function calculationFinancial(): JsonResponse
    {
        $data = $this->reportAction->calculationFinancial();

        return response()->json([
            'data' => $data,
        ]);
    }

    public function destroy(Report $report): JsonResponse
    {
        Gate::authorize('superAdminPermission');
        return $this->reportAction->deleteReport($report);
    }

    public function cancelReportHistory(int $id): JsonResponse //Report that Admin or SuperAdmin is rejected
    {
        return $this->reportAction->createReportHistory($id);
    }

    public function acceptReport(Report $report): JsonResponse
    {
        return $this->reportAction->acceptReport($report);
    }

    public function fetchChangedHistory(int $reportId): JsonResponse
    {
        return $this->reportAction->fetchChangedHistory($reportId);
    }
}
