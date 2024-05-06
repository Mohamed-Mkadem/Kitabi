<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Exports\CategoryExport;
use App\Imports\CategoryImport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Admin\Category\StoreCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::latest()->withCount('books')->paginate(20);
        if ($request->ajax()) {
            $view = view('admin.components.categories-results', ['categories' => $categories])->render();

            return response()->json([
                'html' => $view
            ]);
        }
        return view('admin.categories', ['categories' => $categories]);
    }

    public function export(Request $request)
    {
        $query = $this->getQuery($request);

        $export = new CategoryExport;
        $export->setQuery($query->withCount('books'));
        return Excel::download($export, 'categories.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'mimes:xls,xlsx,csv']
        ]);
        $oldCount = Category::count();

        Excel::import(new CategoryImport(), $request->file('file'));

        $newCount = Category::count();

        $message = $this->buildImportMessage($oldCount, $newCount);

        return redirect()->back()->with('success', $message);
    }

    private function buildImportMessage($oldCount, $newCount)
    {
        $message = '';
        if ($newCount > $oldCount) {
            $imported = $newCount - $oldCount;
            if ($imported == 1) {
                $message = 'تمّ استيراد تصنيف واحد بنجاح';
            } else if ($imported > 1 and $imported <= 10) {
                $message = "تمّ استيراد {$imported} تصنيفات بنجاح";
            } else {
                $message = "تمّ استيراد {$imported} تصنيفا بنجاح";
            }
        } else {
            $message =  'لم يتمّ استيراد أي تصنيف من الملفّ. الملفّ خالي من البيانات الفريدة';
        }
        return $message;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->validated());

        return redirect()->back()->with('success', 'تمّ إضافة التصنيف بنجاح');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return redirect()->back()->with('success', 'تمّ تعديل التصنيف بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {

        if ($category->booksCount()) {
            return redirect()->back()->with('error', 'الرجاء حذف كتب التصنيف كي تتمكّن من حذف التصنيف');
        }

        $category->delete();

        return redirect()->back()->with('success', 'تمّ حذف التصنيف بنجاح');
    }


    public function filter(Request $request)
    {
        $query = $this->getQuery($request);
        $categories = $query->withCount('books')->paginate(20);

        if ($request->ajax()) {
            $view = view('admin.components.categories-results', ['categories' => $categories])->render();

            return response()->json([
                'html' => $view
            ]);
        }
        return view('admin.categories', ['categories' => $categories]);
    }

    private function getQuery(Request $request)
    {


        $query = Category::query();
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
