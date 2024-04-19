<?php

namespace App\Models\Admin;

use App\Traits\HasBooks;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory, HasBooks;

    protected $fillable = ['name'];
}
