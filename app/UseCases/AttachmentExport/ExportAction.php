<?php

namespace App\UseCases\AttachmentExport;

use App\Models\User;
use App\Models\Report;

class ExportAction
{
    public function userReportExport($userId)
    {
        $fileName = User::where('id', $userId)->value('name');
        $result = Report::with('reporter', 'verifier')->where('reporter_id', $userId)->get();
        $data = [
            'fileName'  => $fileName,
            'result'    => $result,
        ];
        return $data;
    }
}
