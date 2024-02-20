<?php

namespace App\Http\Controllers\Api;

use App\Models\Report;
use App\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReportRequest;
use Illuminate\Support\Facades\Gate;
use App\UseCases\Report\ReportAction;
use App\Http\Resources\ReportResource;
use App\Http\Resources\ReportEditHistoryResource;

class ReportController extends Controller
{
    private $reportAction;

    public function __construct(ReportAction $reportAction)
    {
        $this->reportAction = $reportAction;
    }

    public function index(): JsonResponse
    {
        $data = $this->reportAction->fetchData();
        $meta = ResponseHelper::getPaginationMeta($data);
        return response()->json([
            'data' => ReportResource::collection($data),
            'meta' => $meta,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(ReportRequest $request): JsonResponse
    {
        Gate::authorize('adminPermission');
        $formData = $request->all();
        $storeReport = $this->reportAction->createReport($formData);
        $this->reportAction->createNotification(auth()->user()->id, $storeReport->id);
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
    public function update(ReportRequest $request, Report $report): JsonResponse
    {
        Gate::authorize('adminPermission');
        $this->reportAction->updateReport($request, $report);
        return ResponseHelper::success('Successfully Updated', null, 200);
    }

    public function uncheckReport(): JsonResponse
    {
        $data = $this->reportAction->uncheckReport();
        return response()->json([
            'data' => ReportResource::collection($data)
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

    public function cancelReportHistory($id): JsonResponse
    {
        $this->reportAction->createReportHistory($id);
        return ResponseHelper::success('Successfully Rejected', null, 201);
    }

    public function acceptReport(Report $report): JsonResponse
    {
        $this->reportAction->acceptReport($report);
        return ResponseHelper::success('Successfully Accepted', null, 201);
    }

    public function fetchChangedHistory(): JsonResponse
    {
        $data = $this->reportAction->fetchChangedHistory();
        return response()->json([
            'data' => ReportEditHistoryResource::collection($data)
        ]);
    }

    public function filterReport(): JsonResponse
    {
        $data = $this->reportAction->fetchFilterData();
        $meta = ResponseHelper::getPaginationMeta($data);
        return response()->json([
            'data' => ReportResource::collection($data),
            'meta' => $meta
        ]);
    }
}
