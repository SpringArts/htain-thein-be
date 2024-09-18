<?php

namespace App\UseCases\ContactInfo;

use App\Interfaces\ContactInfo\ContactInfoInterface;
use App\Models\ContactInfo;
use App\Services\ContactInfo\DeleteContactInfoService;
use App\Services\ContactInfo\FetchContactInfoService;
use App\Services\ContactInfo\StoreContactInfoService;
use Illuminate\Http\JsonResponse;

class ContactInfoAction
{
    private ContactInfoInterface $contactInfoRepository;

    public function __construct(ContactInfoInterface $contactInfoRepository)
    {
        $this->contactInfoRepository = $contactInfoRepository;
    }

    public function fetchData(array $validateData): JsonResponse
    {
        return (new FetchContactInfoService())($this->contactInfoRepository, $validateData);
    }

    public function createContact(array $data): JsonResponse
    {
        return (new StoreContactInfoService())($this->contactInfoRepository, $data);
    }

    public function deleteContact(ContactInfo $contactInfo): JsonResponse
    {
        return (new DeleteContactInfoService())($this->contactInfoRepository, $contactInfo);
    }
}
