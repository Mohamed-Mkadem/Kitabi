<?php

namespace App\Models\Admin;


use App\Models\Order;
use App\Models\Review;
use App\Models\BookOrder;
use App\Models\Admin\Author;
use App\Models\Admin\Category;
use App\Models\Admin\Publisher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'image',
        'status',
        'category_id',
        'publisher_id',
        'author_id',
        'price',
        'quantity',
        'stock_alert',
        'cost_price',
        'description',
        'rate'
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function updateRate()
    {
        $rateAvg = round($this->reviews()->avg('stars'), 2);
        $this->rate = $rateAvg;
        $this->save();
    }

    public function formattedReviewsCount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->reviews_count >= 10 ? "$this->reviews_count تقييما" :  "$this->reviews_count تقييمات"
        );
    }

    public function rating(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->rate >= 10 ? "$this->reviews_count تقييما" :  "$this->reviews_count تقييمات"
        );
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot([
            'price', 'quantity', 'sub_total', 'image'
        ])->using(BookOrder::class);
    }

    public function orderItems()
    {
        return $this->hasMany(BookOrder::class);
    }

    public function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => number_format(($this->price / 1000), 3),
        );
    }
    public function formattedCostPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => number_format(($this->cost_price / 1000), 3),
        );
    }

    public function isOutOfStock()
    {
        return $this->quantity == 0;
    }
}
