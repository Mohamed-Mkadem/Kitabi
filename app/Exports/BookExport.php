<?php

namespace App\Exports;

use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class BookExport implements FromQuery, WithHeadings, WithMapping, WithStrictNullComparison
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

    public function map($book): array
    {
        $formattedDate = Carbon::parse($book->created_at)->format('Y-m-d - H:i');
        $numberOfOrders = $book->order_items_sum_quantity ?? 0;
        return [
            $book->name,
            $book->category->name,
            $book->author->name,
            $book->publisher->name,
            $numberOfOrders,
            $book->rate,
            $book->status,
            $book->formattedCostPrice,
            $book->formattedPrice,
            $book->quantity,
            $book->stock_alert,
            $formattedDate,
            $book->image
        ];
    }
    public function headings(): array
    {

        return [
            'الإسم',
            'التصنيف',
            'المؤلف',
            'دار النشر',
            'عدد الطلبات',
            'التقييم',
            'الحالة',
            'سعر التكلفة',
            'السعر',
            'الكمّية',
            'كمّية التنبيه',
            'تاريخ الإضافة',
            'مسار الصورة',
        ];
    }
}
