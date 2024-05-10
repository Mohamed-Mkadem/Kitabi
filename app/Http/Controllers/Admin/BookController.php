<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Book;
use App\Exports\BookExport;
use App\Imports\BookImport;
use App\Models\Admin\Author;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Models\Admin\Publisher;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelExcel;
use App\Http\Requests\Admin\Book\StoreBookRequest;
use App\Http\Requests\Admin\Book\UpdateBookRequest;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $books = Book::with(['author', 'publisher', 'category'])->withSum('orderItems', 'quantity')->latest()->paginate();
        $authors = Author::all();
        $publishers = Publisher::all();
        $categories = Category::all();
        if ($request->ajax()) {
            $view = view('admin.components.books-results', ['books' => $books])->render();
            return response()->json([
                'html' => $view
            ]);
        }

        return view('admin.books.books-index', ['books' => $books, 'authors' => $authors, 'publishers' => $publishers, 'categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authors = Author::all();
        $publishers = Publisher::all();
        $categories = Category::all();

        return view('admin.books.books-create', ['authors' => $authors, 'publishers' => $publishers, 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {

        $data = $request->validated();

        $image = $request->file('image');

        $path = $image->store('/books', [
            'disk' => 'public'
        ]);

        Book::create([
            'name' => $data['name'],
            'category_id' => $data['category_id'],
            'publisher_id' => $data['publisher_id'],
            'author_id' => $data['author_id'],
            'description' => $data['description'],
            'status' => $data['status'],
            'quantity' => $data['quantity'],
            'price' => $data['price'],
            'cost_price' => $data['cost_price'],
            'stock_alert' => $data['stock_alert'],
            'image' => $path
        ]);

        return redirect()->back()->with('success', 'تمّ إضافة الكتاب بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book->load('category', 'author', 'publisher')->loadSum('orderItems', 'quantity');
        return view('admin.books.books-show', ['book' => $book]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $authors = Author::all();
        $publishers = Publisher::all();
        $categories = Category::all();
        return view('admin.books.books-edit', ['authors' => $authors, 'publishers' => $publishers, 'categories' => $categories, 'book' => $book]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {

        $data = $request->validated();
        $path = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('/books', [
                'disk' => 'public'
            ]);
        }

        $book->name = $data['name'];
        $book->category_id = $data['category_id'];
        $book->publisher_id = $data['publisher_id'];
        $book->author_id = $data['author_id'];
        $book->description = $data['description'];
        $book->status = $data['status'];
        $book->quantity = $data['quantity'];
        $book->price = $data['price'];
        $book->cost_price = $data['cost_price'];
        $book->stock_alert = $data['stock_alert'];
        if ($path) $book->image = $path;

        $book->save();

        return redirect()->back()->with('success', 'تمّ تعديل الكتاب بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        if ($book->orders()->count()) {
            $book->delete();
            return redirect()->route('admin.books.index')->with('success', 'تمّ حذف الكتاب بنجاح');
        }

        $book->forceDelete();
        return redirect()->route('admin.books.index')->with('success', 'تمّ حذف الكتاب بنجاح');
    }

    public function filter(Request $request)
    {
        $authors = Author::all();
        $publishers = Publisher::all();
        $categories = Category::all();
        $query = $this->getQuery($request);
        $books = $query->with(['author', 'category', 'publisher'])->withSum('orderItems', 'quantity')->paginate();

        if ($request->ajax()) {
            $view = view('admin.components.books-results', ['books' => $books])->render();

            return response()->json([
                'html' => $view
            ]);
        }
        return view('admin.books.books-index', ['books' => $books, 'authors' => $authors, 'publishers' => $publishers, 'categories' => $categories]);
    }

    private function getQuery($request)
    {
        $query = Book::query();

        $search = $request->search ?? '';

        $sort = $request->sort ?? 'newest';

        $min_date = $request->min_date ?? '';
        $max_date = $request->max_date ?? '';

        $min_quantity = $request->min_quantity ?? '';
        $max_quantity = $request->max_quantity ?? '';

        $min_price = $request->min_price ?? '';
        $max_price = $request->max_price ?? '';

        $min_orders = $request->min_orders ?? '';
        $max_orders = $request->max_orders ?? '';

        $categories = $request->categories ?? [];
        $authors = $request->authors ?? [];
        $publishers = $request->publishers ?? [];

        $statuses = $request->statuses ?? [];


        if (!empty($min_orders)) {
            $query->havingRaw('COALESCE(order_items_sum_quantity, 0) >= ?', [$min_orders]);
        }
        if (!empty($max_orders)) {
            $query->havingRaw('COALESCE(order_items_sum_quantity, 0) <= ?', [$max_orders]);
        }

        if (!empty($categories)) {
            $query->whereIn('category_id', $categories);
        }
        if (!empty($publishers)) {
            $query->whereIn('publisher_id', $publishers);
        }
        if (!empty($authors)) {
            $query->whereIn('author_id', $authors);
        }
        if (!empty($statuses)) {
            $query->whereIn('status', $statuses);
        }


        if (!empty($search)) {
            $query->where('name', 'like', "%$search%");
        }
        if (!empty($min_price)) {
            $price = $min_price * 1000;
            $query->where('price', '>=', $price);
        }
        if (!empty($max_price)) {
            $price = $max_price * 1000;
            $query->where('price', '<', $price);
        }
        if (!empty($min_quantity)) {
            $query->where('quantity', '>=', $min_quantity);
        }
        if (!empty($max_quantity)) {
            $query->where('quantity', '<', $max_quantity);
        }
        if (!empty($min_date)) {
            $query->where('created_at', '>=', $min_date);
        }
        if (!empty($max_date)) {
            $maxDateTime = \Carbon\Carbon::parse($max_date)->endOfDay();
            $query->where('created_at', '<=', $maxDateTime);
        }
        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else if ($sort === 'highest_price') {
            $query->orderBy('price', 'desc');
        } else if ($sort === 'lowest_price') {
            $query->orderBy('price', 'asc');
        } else if ($sort === 'highest_quantity') {
            $query->orderBy('quantity', 'desc');
        } else if ($sort === 'lowest_quantity') {
            $query->orderBy('quantity', 'asc');
        } else if ($sort === 'a-z') {
            $query->orderBy('name', 'asc');
        } else if ($sort === 'z-a') {
            $query->orderBy('name', 'desc');
        } else if ($sort === 'highest_orders') {
            $query->orderBy('order_items_sum_quantity', 'desc');
        } else if ($sort === 'lowest_orders') {
            $query->orderBy('order_items_sum_quantity', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query;
    }

    public function export(Request $request)
    {
        $query = $this->getQuery($request);

        $export = new BookExport();
        $export->setQuery($query->with(['publisher', 'author', 'category'])->withSum('orderItems', 'quantity'));
        return Excel::download($export, 'books.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'mimes:xlsx,csv,xls']
        ]);

        $oldCount = Book::count();

        Excel::import(new BookImport(), $request->file('file'));
        $newCount = Book::count();

        $message = $this->buildImportMessage($oldCount, $newCount);

        return redirect()->back()->with('success', $message);
    }
    private function buildImportMessage($oldCount, $newCount)
    {
        $message = '';
        if ($newCount > $oldCount) {
            $imported = $newCount - $oldCount;
            if ($imported == 1) {
                $message = 'تمّ استيراد كتاب واحد بنجاح';
            } else if ($imported > 1 and $imported <= 10) {
                $message = "تمّ استيراد {$imported} كتب بنجاح";
            } else {
                $message = "تمّ استيراد {$imported} كتابا بنجاح";
            }
        } else {
            $message =  'لم يتمّ استيراد أي كتاب من الملفّ. الملفّ خالي من البيانات الفريدة';
        }
        return $message;
    }
}
