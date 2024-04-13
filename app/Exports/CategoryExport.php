<?php

namespace App\Exports;

use App\Models\Admin\Category;

use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithMapping;

class CategoryExport implements FromQuery, WithMapping, WithHeadings
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
    public function map($category): array
    {
        $formattedDate = Carbon::parse($category->created_at)->format('Y-m-d : H:i');
        return [
            $category->name,
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
