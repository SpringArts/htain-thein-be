<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\App\ContactInfo\FetchContactInfoRequest;
use App\Http\Requests\V1\App\ContactInfo\StoreContactInfoRequest;
use App\Models\ContactInfo;
use App\UseCases\ContactInfo\ContactInfoAction;
use Illuminate\Http\JsonResponse;

class ContactInfoController extends Controller
{
    private ContactInfoAction $contactInfoAction;

    public function __construct(ContactInfoAction $contactInfoAction)
    {
        $this->contactInfoAction = $contactInfoAction;
    }

    public function index(FetchContactInfoRequest $request): JsonResponse
    {
        $validatedData = $request->safe()->all();
        return $this->contactInfoAction->fetchData($validatedData);
    }

    public function store(StoreContactInfoRequest $request): JsonResponse
    {
        $validatedData = $request->safe()->all();
        return $this->contactInfoAction->createContact($validatedData);
    }

    public function destroy(ContactInfo $contactInfo): JsonResponse
    {
        return $this->contactInfoAction->deleteContact($contactInfo);
    }
}
