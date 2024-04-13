<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CategoryExport;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Imports\CategoryImport;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::latest()->paginate(20);
        if ($request->ajax()) {
            $view = view('admin.components.categories-table', ['categories' => $categories])->render();

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
        $export->setQuery($query);
        return Excel::download($export, 'categories.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'mimes:xls,xlsx,csv']
        ]);

        Excel::import(new CategoryImport(), $request->file('file'));

        return redirect()->back()->with('success', 'Categories Imported Successfully');
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
        $category->delete();

        return redirect()->back()->with('success', 'تمّ حذف التصنيف بنجاح');
    }


    public function filter(Request $request)
    {
        $query = $this->getQuery($request);
        $categories = $query->paginate(20);

        if ($request->ajax()) {
            $view = view('admin.components.categories-table', ['categories' => $categories])->render();

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
