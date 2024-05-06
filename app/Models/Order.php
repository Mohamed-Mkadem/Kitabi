<?php

namespace App\Models;

use App\Models\User;
use App\Models\BookOrder;
use App\Models\Admin\Book;
use App\Models\StatusHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'amount',
        'no_of_items',
        'note',
        'state_id',
        'city_id',
        'customer_name',
        'shipping_cost',
        'shipping_address',
        'customer_phone',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function books()
    {
        return $this->belongsToMany(Book::class)->withPivot([
            'price', 'quantity', 'sub_total', 'image'
        ])->using(BookOrder::class);
    }

    public function formattedAmount(): Attribute
    {
        return Attribute::make(
            get: fn () => number_format(($this->amount / 1000), 3)
        );
    }
    public function statusHistories()
    {
        return $this->morphMany(StatusHistory::class, 'statusable');
    }
}
