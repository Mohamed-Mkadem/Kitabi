<?php

namespace App\Models\Admin;


use App\Models\Admin\Author;
use App\Models\Admin\Category;
use App\Models\Admin\Publisher;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    ];

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
