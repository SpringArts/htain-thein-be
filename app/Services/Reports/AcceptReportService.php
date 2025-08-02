<?php

namespace App\Services\Reports;

use App\Helpers\ResponseHelper;
use App\Http\Resources\NotiInfoResource;
use App\Interfaces\Notification\NotificationInterface;
use App\Interfaces\Report\ReportInterface;
use App\Mail\NotifyAcceptOrRejectMail;
use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class AcceptReportService
{
    public function __invoke(ReportInterface $reportRepository, Report $report, NotificationInterface $notificationRepository): JsonResponse
    {
        $reportRepository->acceptReport($report);

        $notification = $notificationRepository->getUserNotification($report);
        Mail::to($notification->user->email)->queue(new NotifyAcceptOrRejectMail('Accepted'));

        return ResponseHelper::success('Successfully Accepted', new NotiInfoResource($notification), 200);
    }
}
