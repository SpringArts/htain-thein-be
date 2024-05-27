<?php

namespace App\Http\Controllers\Api;

use App\Models\Report;
use App\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Http\Requests\V1\App\Report\FetchReportFilterRequest;
use App\Http\Requests\V1\App\Report\UncheckReportRequest;
use Illuminate\Support\Facades\Gate;
use App\UseCases\Report\ReportAction;
use App\Http\Resources\ReportResource;
use App\Http\Resources\ReportEditHistoryResource;

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
        $data = $this->reportAction->fetchFilterData($validatedData);
        $meta = ResponseHelper::getPaginationMeta($data);
        return response()->json([
            'data' => ReportResource::collection($data),
            'meta' => $meta,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportRequest $request): JsonResponse
    {
        // Gate::authorize('adminPermission');
        $formData = $request->safe()->all();
        $authUserId = getAuthUserOrFail()->id;
        $storeReport = $this->reportAction->createReport($formData);
        $this->reportAction->createNotification($authUserId, $storeReport->id);
        return ResponseHelper::success('Successfully created', null, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report): JsonResponse
    {
        return response()->json([
            'data' => new ReportResource($report)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReportRequest $request, Report $report): JsonResponse
    {
        $this->reportAction->updateReport($request->safe()->all(), $report);
        return ResponseHelper::success('Successfully Updated', null, 200);
    }

    public function uncheckReport(UncheckReportRequest $request): JsonResponse
    {
        $validatedData = $request->safe()->all();
        $data = $this->reportAction->uncheckReport($validatedData);
        $meta = ResponseHelper::getPaginationMeta($data);
        return response()->json([
            'data' => ReportResource::collection($data),
            'meta' => $meta,
        ]);
    }

    public function calculationFinancial(): JsonResponse
    {
        $data = $this->reportAction->calculationFinancial();

        return response()->json([
            'data' => $data
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report): JsonResponse
    {
        Gate::authorize('superAdminPermission');
        $this->reportAction->deleteReport($report);
        return ResponseHelper::success('Successfully deleted', null, 200);
    }

    public function cancelReportHistory(int $id): JsonResponse //Report that Admin or SuperAdmin is rejected
    {
        $this->reportAction->createReportHistory($id);
        return ResponseHelper::success('Successfully Rejected', null, 201);
    }

    public function acceptReport(Report $report): JsonResponse
    {
        $this->reportAction->acceptReport($report);
        return ResponseHelper::success('Successfully Accepted', null, 201);
    }

    public function fetchChangedHistory(int $reportId): JsonResponse
    {
        $data = $this->reportAction->fetchChangedHistory($reportId);
        return response()->json([
            'data' => ReportEditHistoryResource::collection($data)
        ]);
    }
}
