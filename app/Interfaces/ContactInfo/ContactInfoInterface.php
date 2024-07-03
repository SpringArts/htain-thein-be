<?php

namespace App\Interfaces\ContactInfo;

use App\Models\ContactInfo;
use Illuminate\Pagination\LengthAwarePaginator;

interface ContactInfoInterface
{
    public function fetchData(int $limit, int $page): LengthAwarePaginator;

    public function createContact(array $formData): ContactInfo;

    public function deleteContact(ContactInfo $contact): ?bool;
}
