<?php

namespace App\Http\Controllers\Api;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\UseCases\AttachmentExport\ExportAction;

class AttachmentExportController extends Controller
{
    private $excelExport;
    public function __construct(ExportAction $excelExport)
    {
        $this->excelExport = $excelExport;
    }

    public function userReportExport($id)
    {
        $data = $this->excelExport->userReportExport($id);
        return (new UsersExport($data['query'], $data['fileName']))->download();
    }
}
