<?php

namespace App\Http\Controllers\Client;

use App\Models\Review;
use App\Models\Admin\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    public function store(Request $request, Book $book)
    {
        $user = $request->user();
        if (!$user->hasBoughtThisBook($book->id) || $user->hasReviewedThisBook($book->id)) {
            return abort(403);
        }

        $request->validate([
            'comment' => ['string', 'nullable'],
            'stars' => ['required', 'in:1,2,3,4,5', 'numeric']
        ]);

        Review::create([
            'user_id' => $request->user()->id,
            'book_id' => $book->id,
            'comment' => $request->comment,
            'stars' => $request->stars,
        ]);
        $book->updateRate();
        return redirect()->back()->with('success', 'تمّ إضافة التقييم بنجاح. شكرا');
    }
}
