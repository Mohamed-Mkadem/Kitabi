<?php

namespace App\Models;

use App\Models\Admin\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'comment',
        'stars',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class)->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
