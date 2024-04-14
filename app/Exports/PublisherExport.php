<?php

namespace App\Exports;

use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PublisherExport implements FromQuery, WithHeadings, WithMapping
{

    protected $query;

    public function setQuery($query)
    {
        $this->query = $query;
    }

    public function query()
    {
        return $this->query;
    }

    public function map($publisher): array
    {
        $formattedDate = Carbon::parse($publisher->created_at)->format('Y-m-d : H:i');
        return [
            $publisher->name,
            $formattedDate
        ];
    }
    public function headings(): array
    {
        return [
            'Name', 'Creation Date'
        ];
    }
}
