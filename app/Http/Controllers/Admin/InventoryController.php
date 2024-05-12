<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Author;
use App\Models\Admin\Book;
use App\Models\Admin\Category;
use App\Models\Admin\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index()
    {
        $books = Book::with(['author', 'publisher', 'category'])->orderBy('price', 'desc')->paginate();
        $publishers = Publisher::all();
        $categories = Category::all();
        $authors = Author::all();
        $stockStatistics = $this->getStockStatistics();
        $stockFinanacialStiatistics = $this->stockFinancialStatistics();

        return view(
            'admin.inventory',
            [
                'books' => $books,
                'publishers' => $publishers,
                'authors' => $authors,
                'categories' => $categories,
                'stockStatistics' => $stockStatistics,
                'stockFinanacialStiatistics' => $stockFinanacialStiatistics,
            ]
        );
    }


    private function getStockStatistics()
    {
        $outOfStock = Book::where('quantity', 0)->count();
        $inStock = Book::whereColumn('quantity', '>', 'stock_alert')->count();
        $stockAlert = Book::whereColumn('quantity', '<=', 'stock_alert')->where('quantity', '!=', 0)->count();
        $booksCount = Book::count();
        return compact('outOfStock', 'inStock', 'stockAlert', 'booksCount');
    }

    private function stockFinancialStatistics()
    {
        $stockCost = 0;
        $stockPrice = 0;
        $expectedEarnings = 0;
        $books = Book::all();

        foreach ($books as $book) {
            $stockCost += $book->cost_price * $book->quantity;
            $stockPrice += $book->price * $book->quantity;
        }
        $expectedEarnings = $stockPrice - $stockCost;

        return [
            'expectedEarnings' => number_format(($expectedEarnings / 1000), 3),
            'stockCost' => number_format(($stockCost / 1000), 3),
            'stockPrice' => number_format(($stockPrice / 1000), 3)
        ];
    }


    public function manage(Book $book, Request $request)
    {

        $this->authorize('update', Book::class);

        $request->validate([
            'quantity' => ['required', 'min:1', 'numeric'],
            'operation' => ['required', 'in:decrement,increment']
        ]);

        if ($request->operation == 'decrement') {
            if (($book->quantity - $request->quantity) < 0) {
                return redirect()->back()->with('error', 'الكمّية المراد حذفها أكثر من الموجودة في المخزن');
            } else {
                $book->quantity = DB::raw('quantity - ' . $request->quantity);
                $book->save();
            }
        } else {
            $book->quantity = DB::raw('quantity + ' . $request->quantity);
            $book->save();
        }

        return redirect()->back()->with('success', 'تمّ تحديث كمّية المنتج بنجاح');
    }



    public function filter(Request $request)
    {
        $books = $this->getQuery($request)->with(['author', 'publisher', 'category'])->paginate();
        $publishers = Publisher::all();
        $categories = Category::all();
        $authors = Author::all();
        $stockStatistics = $this->getStockStatistics();
        $stockFinanacialStiatistics = $this->stockFinancialStatistics();

        return view(
            'admin.inventory',
            [
                'books' => $books,
                'publishers' => $publishers,
                'authors' => $authors,
                'categories' => $categories,
                'stockStatistics' => $stockStatistics,
                'stockFinanacialStiatistics' => $stockFinanacialStiatistics,
            ]
        );
    }

    private function getQuery(Request $request)
    {
        $query = Book::query();

        $search = $request->input('search');

        $min_quantity = $request->input('min_quantity');
        $max_quantity = $request->input('max_quantity');

        $min_price = $request->input('min_price');
        $max_price = $request->input('max_price');

        $min_cost = $request->input('min_cost');
        $max_cost = $request->input('max_cost');

        $max_stock_alert = $request->input('max_stock_alert');
        $min_stock_alert = $request->input('min_stock_alert');

        $sort = $request->input('sort');
        $categories = $request->input('categories');
        $authors = $request->input('authors');
        $publishers = $request->input('publishers');

        $statuses = $request->input('statuses');
        if ($statuses != null) {
            $query->where(function ($query) use ($statuses) {
                foreach ($statuses as $status) {
                    if ($status === 'in-stock') {
                        $query->orWhereColumn('quantity', '>', 'stock_alert');
                    } elseif ($status === 'out-of-stock') {
                        $query->orWhere('quantity', 0);
                    } elseif ($status === 'stock-alert') {
                        $query->orWhere(function ($query) {
                            $query->where('quantity', '!=', 0)
                                ->whereColumn('quantity', '<=', 'stock_alert');
                        });
                    }
                }
            });
        }
        if ($categories != null) {
            $query->whereIn('category_id', $categories);
        }
        if ($authors != null) {
            $query->whereIn('author_id', $authors);
        }
        if ($publishers != null) {
            $query->whereIn('publisher_id', $publishers);
        }




        if ($search != null) {
            $query->where('name', 'like', "%$search%");
        }

        if ($min_quantity != null) {
            $query->where('quantity', '>=', $min_quantity);
        }

        if ($max_quantity != null) {
            $query->where('quantity', '<=', $max_quantity);
        }

        if ($min_stock_alert != null) {
            $query->where('stock_alert', '>=', $min_stock_alert);
        }

        if ($max_stock_alert != null) {
            $query->where('stock_alert', '<=', $max_stock_alert);
        }

        if ($min_price != null) {
            $query->where('price', '>=', ($min_price * 1000));
        }

        if ($max_price != null) {
            $query->where('price', '<=', ($max_price * 1000));
        }
        if ($min_cost != null) {
            $query->where('cost_price', '>=', ($min_cost * 1000));
        }

        if ($max_cost != null) {
            $query->where('cost_price', '<=', ($max_cost * 1000));
        }

        if ($sort === 'highest_price') {
            $query->orderBy('price', 'desc');
        }
        if ($sort === 'lowest_price') {
            $query->orderBy('price', 'asc');
        }
        if ($sort === 'highest_cost') {
            $query->orderBy('cost_price', 'desc');
        }
        if ($sort === 'lowest_cost') {
            $query->orderBy('cost_price', 'asc');
        }
        if ($sort === 'highest_quantity') {
            $query->orderBy('quantity', 'desc');
        }
        if ($sort === 'lowest_quantity') {
            $query->orderBy('quantity', 'asc');
        }
        if ($sort === 'highest_stock_alert') {
            $query->orderBy('stock_alert', 'desc');
        }
        if ($sort === 'lowest_stock_alert') {
            $query->orderBy('stock_alert', 'asc');
        }



        return $query;
    }
}
