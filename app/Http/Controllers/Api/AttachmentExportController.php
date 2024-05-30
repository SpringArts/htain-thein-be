<?php

namespace App\Http\Controllers\Api;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\UseCases\AttachmentExport\ExportAction;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Http\Response;

class AttachmentExportController extends Controller
{
    private ExportAction $excelExport;
    public function __construct(ExportAction $excelExport)
    {
        $this->excelExport = $excelExport;
    }

    public function userReportExport(int $id): Response|BinaryFileResponse
    {
        $data = $this->excelExport->userReportExport($id);
        $export = new UsersExport($data['query']);
        $fileName = $data['fileName'] ? $this->fileNameChanger($data['fileName']) : 'users_report.xlsx';
        return $export->download($fileName);
    }

    private function fileNameChanger(string $fileName): string
    {
        $fileName =  $fileName . '_' . now()->format('YmdHis') . '.xlsx';
        return $fileName;
    }
}
