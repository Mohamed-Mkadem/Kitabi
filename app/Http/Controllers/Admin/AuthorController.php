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
        $authors = Author::latest()->paginate(20);
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
        $author->delete();
        return redirect()->back()->with('success', 'تمّ حذف المؤلّف بنجاح');
    }

    public function export(Request $request)
    {
        $query = $this->getQuery($request);

        $export = new AuthorExport;
        $export->setQuery($query);

        return Excel::download($export, 'authors.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'mimes:xls,xlsx,csv']
        ]);

        Excel::import(new AuthorImport(), $request->file('file'));

        return redirect()->back()->with('success', 'تمّ استيراد المؤلّفين بنجاح');
    }

    public function filter(Request $request)
    {
        $query = $this->getQuery($request);
        $authors = $query->paginate(20);

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
