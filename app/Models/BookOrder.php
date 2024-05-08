<?php

namespace App\Models;

use App\Models\Admin\Book;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BookOrder extends Pivot
{
    protected $fillable = [
        'book_id',
        'order_id',
        'price',
        'image',
        'quantity',
        'sub_total',
    ];

    public function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => number_format(($this->price / 1000), 3)
        );
    }
    public function formattedSubTotal(): Attribute
    {
        return Attribute::make(
            get: fn () => number_format(($this->sub_total / 1000), 3)
        );
    }
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
