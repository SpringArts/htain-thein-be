<?php

namespace App\Services\Reports;

use App\Helpers\ResponseHelper;
use App\Http\Resources\NotiInfoResource;
use App\Interfaces\Notification\NotificationInterface;
use App\Interfaces\Report\ReportInterface;
use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AcceptReportService
{
    public function __invoke(ReportInterface $reportRepository, Report $report, NotificationInterface $notificationRepository): JsonResponse
    {
        try {
            $reportRepository->acceptReport($report);
            $notification = $notificationRepository->getUserNotification($report);

            return ResponseHelper::success('Successfully Accepted', new NotiInfoResource($notification), 200);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
