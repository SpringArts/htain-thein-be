<?php

namespace App\Services\Reports;

use App\Helpers\ResponseHelper;
use App\Interfaces\Report\ReportInterface;
use App\Models\Report;
use App\Services\Reports\FinancialCalculatorService;
use App\UseCases\NotiInfo\NotiInfoAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use InvalidArgumentException;

class EditReportService
{
    public function __invoke(array $data, ReportInterface $reportRepository, NotiInfoAction $notiInfoAction, Report $report): JsonResponse
    {
        try {
            $authUserId = getAuthUserOrFail()->id;
            if ($data['type'] != $report->type) {
                FinancialCalculatorService::checkExpensePossible($data);
            }
            $oldData = $report->toArray();
            $reportRepository->updateReport($data, $report);
            $newData = $report->toArray(); //take new data after update
            ReportEditHistoryService::editHistory($oldData, $newData);
            $notiInfoAction->createNotification([
                'user_id' => $authUserId,
                'report_id' => $report->id,
                'type' => 'report',
            ]);

            return ResponseHelper::success('Successfully Updated', null, Response::HTTP_OK);
        } catch (InvalidArgumentException $e) {
            return ResponseHelper::fail($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
