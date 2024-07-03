<?php

namespace App\Services\Reports;

use App\Helpers\ResponseHelper;
use App\Http\Resources\ReportResource;
use App\Interfaces\Report\ReportInterface;
use App\Models\Report;
use App\Services\Reports\FinancialCalculatorService;
use App\UseCases\NotiInfo\NotiInfoAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use InvalidArgumentException;

class CreateReportService
{
    public function __invoke(array $data, ReportInterface $reportRepository, NotiInfoAction $notiInfoAction): JsonResponse
    {
        try {
            FinancialCalculatorService::checkExpensePossible($data);
            $report = $reportRepository->createReport($data);
            $this->createNotification($notiInfoAction, $report);
            return ResponseHelper::success('Successfully created', new ReportResource($report), Response::HTTP_CREATED);
        } catch (InvalidArgumentException $e) {
            return ResponseHelper::fail($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function createNotification(NotiInfoAction $notiInfoAction, Report $report): void
    {
        $authUserId = getAuthUserOrFail()->id;

        $notiInfoAction->createNotification([
            'user_id' => $authUserId,
            'report_id' => $report->id,
            'type' => 'report',
        ]);
    }
}
