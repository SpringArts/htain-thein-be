<?php

namespace App\Repositories\ContactInfo;

use App\Interfaces\ContactInfo\ContactInfoInterface;
use App\Models\ContactInfo;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactInfoRepository implements ContactInfoInterface
{
    public function fetchData(int $limit, int $page): LengthAwarePaginator
    {
        return ContactInfo::orderBy('created_at', 'desc')->paginate($limit, ['*'], 'page', $page)->withQueryString();
    }

    public function createContact(array $data): ContactInfo
    {
        return ContactInfo::create($data);
    }

    public function deleteContact(ContactInfo $contact): ?bool
    {
        return $contact->delete();
    }
}
