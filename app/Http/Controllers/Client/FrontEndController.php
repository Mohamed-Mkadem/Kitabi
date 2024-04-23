<?php

namespace App\Http\Controllers\Client;

use App\Models\Admin\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontEndController extends Controller
{
    public function index()
    {
        $bestSellingBooks = Book::with('category', 'author', 'publisher')->take(8)->get();

        $latestBooks = Book::with('category', 'author', 'publisher')->latest()->take(8)->get();

        return view('client.home', ['bestSellingBooks' => $bestSellingBooks, 'latestBooks' => $latestBooks]);
    }
}
