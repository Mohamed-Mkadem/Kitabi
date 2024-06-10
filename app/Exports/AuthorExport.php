<?php

namespace App\Exports;

use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class AuthorExport implements FromQuery, WithMapping, WithHeadings, WithStrictNullComparison
{

    protected $query;
    public function setQuery($query)
    {
        $this->query = $query;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        return $this->query;
    }

    public function map($author): array
    {
        $formattedDate = Carbon::parse($author->created_at)->format('Y-m-d : H:i');
        $booksCount = $author->books_count ?? 0;
        return [
            $author->name,
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
