<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AuthorExport;
use App\Models\Admin\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Author\StoreAuthorRequest;
use App\Http\Requests\Admin\Author\UpdateAuthorRequest;
use App\Imports\AuthorImport;
use Maatwebsite\Excel\Facades\Excel;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $authors = Author::latest()->withcount('books')->paginate(20);
        if ($request->ajax()) {
            $view = view('admin.components.authors-results', ['authors' => $authors])->render();

            return response()->json([
                'html' => $view
            ]);
        }
        return view('admin.authors', ['authors' => $authors]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request)
    {
        Author::create($request->validated());

        return redirect()->back()->with('success', 'تمّ إضافة المؤلّف بنجاح');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthorRequest $request, Author $author)
    {
        $author->update($request->validated());

        return redirect()->back()->with('success', 'تمّ تعديل المؤلّف بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {

        if ($author->booksCount()) {
            return redirect()->back()->with('error', 'الرجاء حذف كتب المؤلّف كي تتمكّن من حذف المؤلّف');
        }

        $author->delete();
        return redirect()->back()->with('success', 'تمّ حذف المؤلّف بنجاح');
    }

    public function export(Request $request)
    {
        $query = $this->getQuery($request);

        $export = new AuthorExport;
        $export->setQuery($query->withCount('books'));

        return Excel::download($export, 'authors.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'mimes:xls,xlsx,csv']
        ]);

        $oldCount = Author::count();
        Excel::import(new AuthorImport(), $request->file('file'));
        $newCount = Author::count();

        $message = $this->buildImportMessage($oldCount, $newCount);

        return redirect()->back()->with('success', $message);
    }

    private function buildImportMessage($oldCount, $newCount)
    {
        $message = '';
        if ($newCount > $oldCount) {
            $imported = $newCount - $oldCount;
            if ($imported == 1) {
                $message = 'تمّ استيراد مؤلّف واحد بنجاح';
            } else if ($imported > 1 and $imported <= 10) {
                $message = "تمّ استيراد {$imported} مؤلّفين بنجاح";
            } else {
                $message = "تمّ استيراد {$imported} مؤلّفا بنجاح";
            }
        } else {
            $message =  'لم يتمّ استيراد أي مؤلّف من الملفّ. الملفّ خالي من البيانات الفريدة';
        }
        return $message;
    }


    public function filter(Request $request)
    {
        $query = $this->getQuery($request);
        $authors = $query->withcount('books')->paginate(20);

        if ($request->ajax()) {
            $view = view('admin.components.authors-results', ['authors' => $authors])->render();

            return response()->json([
                'html' => $view
            ]);
        }

        return view('admin.authors', ['authors' => $authors]);
    }

    private function getQuery(Request $request)
    {
        $query = Author::query();

        $search = $request->search ?? '';

        $sort = $request->sort ?? 'newest';

        $min_date = $request->min_date ?? '';
        $max_date = $request->max_date ?? '';

        $min_books_count = $request->input('min_books_count');
        $max_books_count = $request->input('max_books_count');

        if ($min_books_count !== null) {
            $query->having('books_count', '>=', $min_books_count);
        }

        if ($max_books_count !== null) {
            $query->having('books_count', '<=', $max_books_count);
        }


        if (!empty($search)) {
            $query->where('name', 'like', "%$search%");
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
        } else {
            $query->orderBy('created_at', 'desc');
        }
        return $query;
    }
}
