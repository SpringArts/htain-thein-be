<?php

namespace App\UseCases\AttachmentExport;

use App\Models\User;
use App\Interfaces\Report\ReportInterface;

class ExportAction
{
    private ReportInterface $reportRepository;

    public function __construct(ReportInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function userReportExport($userId)
    {
        $fileName = User::where('id', $userId)->value('name');
        $query = $this->reportRepository->userReportDownload($userId);
        return [
            'query' => $query,
            'fileName' => $fileName
        ];
    }
}
