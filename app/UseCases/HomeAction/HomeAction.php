<?php

namespace App\UseCases\HomeAction;

use App\Interfaces\Report\ReportInterface;
use App\Models\User;

class HomeAction
{
    private ReportInterface $reportRepository;

    public function __construct(ReportInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    //TODO List
    public function fetchData(): array
    {
        $users = User::count();
        $reports = $this->reportRepository->getAllReports();
        $data = [
            'users' => $users,
            'reports' => $reports,
        ];

        return $data;
    }
}
