<?php

namespace App\Services\ContactInfo;

use App\Helpers\ResponseHelper;
use App\Interfaces\ContactInfo\ContactInfoInterface;
use App\Models\ContactInfo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DeleteContactInfoService
{
    public function __invoke(ContactInfoInterface $contactInfoRepository, ContactInfo $contactInfo): JsonResponse
    {
        try {
            $contactInfoRepository->deleteContact($contactInfo);
            return ResponseHelper::success('Contact deleted successfully', null, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
