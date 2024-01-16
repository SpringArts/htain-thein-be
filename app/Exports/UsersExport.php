<?php

namespace App\Exports;

use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;



class UsersExport implements FromQuery, WithHeadings,  WithMapping
{
    use Exportable;

    private $query;

    private $fileName;

    private $writerType = Excel::XLSX;

    public function __construct($query, $fileName)
    {
        $this->query = $query;
        $this->fileName = $fileName . '_' . now()->format('YmdHis') . '.xlsx';
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

    public function query()
    {
        return $this->query;
    }
    public function map($row): array
    {
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
