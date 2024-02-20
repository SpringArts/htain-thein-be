<?php

namespace App\UseCases\HomeAction;

use App\Interfaces\Report\ReportInterface;
use App\Models\ContactInfo;
use App\Models\User;

class HomeAction
{
    private ReportInterface $reportRepository;

    public function __construct(ReportInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }
    #TODO List
    public function fetchData(): array
    {
        $users = User::all()->count();
        $reports = $this->reportRepository->getAllReports();
        $data = [
            'users' => $users,
            'reports' => $reports
        ];
        return $data;
    }

    public function storeContactInfo(array $formData): int
    {
        $storeData = ContactInfo::create($formData);
        return 201;
    }
}
