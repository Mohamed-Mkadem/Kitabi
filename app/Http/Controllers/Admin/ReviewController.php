<?php

namespace App\Http\Controllers\Admin;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{

    public function index()
    {
        $reviews = Review::with([
            'book.author', 'book.publisher',
            'user' => function ($query) {
                $query->withCount('reviews');
            }, 'book' => function ($query) {
                $query->withCount('reviews');
            }
        ])->latest()->paginate();

        return view('admin.reviews', ['reviews' => $reviews]);
    }


    public function filter(Request $request)
    {
        $query = Review::query();

        $search = $request->input('search');
        $sort = $request->input('sort');
        $min_date = $request->input('min_date');
        $max_date = $request->input('max_date');
        $stars = $request->input('stars');

        if ($search != null) {
            $query->whereHas('book', function ($subQuery) use ($search) {
                $subQuery->where('name', 'like', "%$search%");
            });
        }

        if ($stars != null) {
            $query->whereIn('stars', $stars);
        }

        if ($min_date != null) {
            $query->where('created_at', '>=', $min_date);
        }
        if ($max_date != null) {
            $maxDateTime = \Carbon\Carbon::parse($max_date)->endOfDay();
            $query->where('created_at', '<=', $maxDateTime);
        }
        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        }
        if ($sort === 'newest') {
            $query->orderBy('created_at', 'desc');
        }
        if ($sort === 'highest_rate') {
            $query->orderBy('stars', 'desc');
        }
        if ($sort === 'lowest_rate') {
            $query->orderBy('stars', 'asc');
        }

        $reviews = $query->with([
            'book.author', 'book.publisher',
            'user' => function ($query) {
                $query->withCount('reviews');
            }, 'book' => function ($query) {
                $query->withCount('reviews');
            }
        ])->paginate();
        return view('admin.reviews', ['reviews' => $reviews]);
    }



    public function destroy(Review $review)
    {
        $review->delete();
        $review->book->updateRate();
        return redirect()->back()->with('success', 'تمّ حذف التقييم بنجاح');
    }
}
