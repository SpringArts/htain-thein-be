<?php

namespace App\UseCases\HomeAction;

use App\Models\ContactInfo;
use App\Models\Report;
use App\Models\User;

class HomeAction
{
    #TODO List
    public function fetchData(): array
    {
        $users = User::all()->count();
        $reports = Report::all();
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
