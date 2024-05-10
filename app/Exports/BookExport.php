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
            'Name',
            'Category',
            'Author',
            'Publisher',
            'Number of Orders',
            'Status',
            'Cost Price',
            'Price ',
            'Quantity',
            'Stock Alert',
            'Creation Date',
            'Image',
        ];
    }
}
