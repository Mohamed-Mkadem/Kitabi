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
        $books = Book::with(['category', 'author', 'publisher'])->withCount('reviews')->paginate();
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
        $book->load(['category', 'author', 'publisher', 'reviews.user'])->loadCount('reviews');
        $starsCounts = $this->getStarsStatistics($book);
        return view('client.book', ['book' => $book, 'starsCounts' => $starsCounts]);
    }

    public function getStarsStatistics($book)
    {
        $reviewsCount = $book->reviews()->count();
        $count = $fiveStarsCount = $book->reviews()->where('stars', 5)->count();
        $fourStarsCount = $book->reviews()->where('stars', 4)->count();
        $threeStarsCount = $book->reviews()->where('stars', 3)->count();
        $twoStarsCount = $book->reviews()->where('stars', 2)->count();
        $oneStarsCount = $book->reviews()->where('stars', 1)->count();
        return [
            '5' => [
                'count' => $fiveStarsCount,
                'percentage' => $reviewsCount ? round(($fiveStarsCount / $reviewsCount) * 100) : 0
            ],
            '4' => [
                'count' => $fourStarsCount,
                'percentage' => $reviewsCount ? round(($fourStarsCount / $reviewsCount) * 100) : 0
            ],
            '3' => [
                'count' => $threeStarsCount,
                'percentage' => $reviewsCount ? round(($threeStarsCount / $reviewsCount) * 100) : 0
            ],
            '2' => [
                'count' => $twoStarsCount,
                'percentage' => $reviewsCount ? round(($twoStarsCount / $reviewsCount) * 100) : 0
            ],
            '1' => [
                'count' => $oneStarsCount,
                'percentage' => $reviewsCount ? round(($oneStarsCount / $reviewsCount) * 100) : 0
            ],


        ];
    }
    public function isAvailableProduct($id, $quantity)
    {
        $book = Book::findOrFail($id);
        // create the not found scenario on frontEnd
        $book_quantity = $book->quantity;

        if ($book_quantity >= $quantity) {
            return [
                'availability' => true,
                'quantity' => $book_quantity
            ];
        }

        return [
            'availability' => false,
            'quantity' => $book_quantity
        ];
    }
}
