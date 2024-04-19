<?php

namespace App\Traits;

use App\Models\Admin\Book;


trait HasBooks
{


    public function books()
    {
        return $this->hasMany(Book::class);
    }


    public function booksCount()
    {
        return $this->books()->count();
    }
}
