<?php

namespace App\UseCases\ContactInfo;

use App\Helpers\ResponseHelper;
use App\Interfaces\ContactInfo\ContactInfoInterface;
use App\Models\ContactInfo;
use App\Services\ContactInfo\DeleteContactInfoService;
use App\Services\ContactInfo\FetchContactInfoService;
use App\Services\ContactInfo\StoreContactInfoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ContactInfoAction
{
    private ContactInfoInterface $contactInfoRepository;

    public function __construct(ContactInfoInterface $contactInfoRepository)
    {
        $this->contactInfoRepository = $contactInfoRepository;
    }

    public function fetchData(array $validateData): JsonResponse
    {
        try {
            return (new FetchContactInfoService())($this->contactInfoRepository, $validateData);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function createContact(array $data): JsonResponse
    {
        try {
            return (new StoreContactInfoService())($this->contactInfoRepository, $data);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteContact(ContactInfo $contactInfo): JsonResponse
    {
        try {
            return (new DeleteContactInfoService())($this->contactInfoRepository, $contactInfo);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
