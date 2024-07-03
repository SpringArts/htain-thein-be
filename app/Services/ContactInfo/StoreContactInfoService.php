<?php

namespace App\Services\ContactInfo;

use App\Helpers\ResponseHelper;
use App\Http\Resources\ContactInfoResource;
use App\Interfaces\ContactInfo\ContactInfoInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class StoreContactInfoService
{
    public function __invoke(ContactInfoInterface $contactInfoRepository, array $data): JsonResponse
    {
        try {
            $contact = $contactInfoRepository->createContact($data);
            return ResponseHelper::success('Record Successfully', new ContactInfoResource($contact), Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
