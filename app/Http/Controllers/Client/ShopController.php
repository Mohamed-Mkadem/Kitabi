<?php

namespace App\Http\Controllers\Client;

use App\Models\Admin\Book;
use App\Models\Admin\Author;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Models\Admin\Publisher;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function shop(Request $request)
    {
        $categories = Category::all();
        $publishers = Publisher::all();
        $authors = Author::all();
        $books = Book::with(['category', 'author', 'publisher'])->paginate();
        if ($request->ajax()) {
            $view = view('client.components.shop-results-container', ['books' => $books])->render();

            return response()->json(
                [
                    'html' => $view

                ]
            );
        }
        return view('client.shop', [
            'books' => $books, 'categories' => $categories, 'authors' => $authors, 'publishers' => $publishers
        ]);
    }

    public function filter(Request $request)
    {
        $categories = Category::all();
        $publishers = Publisher::all();
        $authors = Author::all();
        $query = Book::query();
        $sort = $request->sort ?? 'newest';
        $search = $request->search ?? '';
        $min_price = $request->min_price ?? '';
        $max_price = $request->max_price ?? '';
        $filters_categories = $request->categories ?? [];
        $filters_authors = $request->authors ?? [];
        $filters_publishers = $request->publishers ?? [];

        if (!empty($search)) {
            $query->where('name', 'like', "%$search%");
        }
        if (!empty($min_price)) {
            $query->where('price', '>', ($min_price * 1000));
        }
        if (!empty($max_price)) {
            $query->where('price', '<', ($max_price * 1000));
        }

        if (!empty($filters_categories)) {
            $query->whereIn('category_id', $filters_categories);
        }
        if (!empty($filters_publishers)) {
            $query->whereIn('publisher_id', $filters_publishers);
        }
        if (!empty($filters_authors)) {
            $query->whereIn('author_id', $filters_authors);
        }

        if ($sort == 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else if ($sort == 'highest_price') {
            $query->orderBy('price', 'desc');
        } else if ($sort == 'lowest_price') {
            $query->orderBy('price', 'asc');
        }


        $books = $query->with(['category', 'author', 'publisher'])->latest()->paginate();

        if ($request->ajax()) {
            $view = view('client.components.shop-results-container', ['books' => $books])->render();

            return response()->json(
                [
                    'html' => $view

                ]
            );
        }

        return view('client.shop', [
            'books' => $books, 'categories' => $categories, 'authors' => $authors, 'publishers' => $publishers
        ]);
    }

    public function book(Book $book)
    {
        $book->load(['category', 'author', 'publisher']);

        return view('client.book', ['book' => $book]);
    }
}
