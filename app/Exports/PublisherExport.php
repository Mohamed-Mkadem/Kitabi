<?php

namespace App\Exports;

use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class PublisherExport implements FromQuery, WithHeadings, WithMapping, WithStrictNullComparison
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
        $booksCount = $publisher->books_count ?? 0;
        return [
            $publisher->name,
            $booksCount,
            $formattedDate
        ];
    }
    public function headings(): array
    {
        return [
            'الإسم', 'عدد الكتب', 'تاريخ الإضافة'
        ];
    }
}
