<?php

namespace App\Exports;

use App\Models\Admin\Category;

use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class CategoryExport implements FromQuery, WithMapping, WithHeadings, WithStrictNullComparison
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
