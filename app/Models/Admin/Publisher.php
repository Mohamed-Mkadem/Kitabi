<?php

namespace App\Models\Admin;

use App\Models\Admin\Book;
use App\Traits\HasBooks;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Publisher extends Model
{
    use HasFactory, HasBooks;

    protected $fillable = ['name'];
}
