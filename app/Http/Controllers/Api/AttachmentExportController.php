<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;
use App\UseCases\AttachmentExport\ExportAction;
use Illuminate\Http\JsonResponse;

class AttachmentExportController extends Controller
{
    private $excelExport;
    public function __construct(ExportAction $excelExport)
    {
        $this->excelExport = $excelExport;
    }

    public function userReportExport($id): JsonResponse
    {
        $data = $this->excelExport->userReportExport($id);
        return response()->json([
            'data' => ReportResource::collection($data['result']),
            'fileName' => $data['fileName']
        ]);
    }
}
