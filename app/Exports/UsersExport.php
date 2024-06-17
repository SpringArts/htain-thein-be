<?php

namespace App\Exports;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    private Builder $query;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function headings(): array
    {
        return [
            'Amount',
            'Description',
            'Status',
            'Type',
            'Reporter_ID',
            'Verifier_ID',
        ];
    }

    public function query(): Builder
    {
        return $this->query;
    }

    public function map($row): array
    {
        /** @var \stdClass $row */
        return [
            $row->amount,
            $row->description,
            $row->confirm_status ? 'Confirmed' : 'Pending',
            $row->type,
            $row->reporter->name,
            $row->verifier->name,
        ];
    }
}
