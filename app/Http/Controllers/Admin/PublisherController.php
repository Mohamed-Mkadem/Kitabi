<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\Publisher;
use App\Exports\PublisherExport;
use App\Imports\PublisherImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Admin\Publisher\StorePublisherRequest;
use App\Http\Requests\Admin\Publisher\UpdatePublisherRequest;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $publishers = Publisher::latest()->withCount('books')->paginate(20);
        if ($request->ajax()) {
            $view = view('admin.components.publishers-results', ['publishers' => $publishers])->render();

            return response()->json([
                'html' => $view
            ]);
        }
        return view('admin.publishers', ['publishers' => $publishers]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePublisherRequest $request)
    {
        Publisher::create($request->validated());

        return redirect()->back()->with('success', 'تمّ إضافة الناشر بنجاح');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePublisherRequest $request, Publisher $publisher)
    {
        $publisher->update($request->validated());

        return redirect()->back()->with('success', 'تمّ تعديل الناشر بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publisher $publisher)
    {

        if ($publisher->booksCount()) {
            return redirect()->back()->with('error', 'الرجاء حذف كتب الناشر كي تتمكّن من حذف الناشر');
        }

        $publisher->delete();

        return redirect()->back()->with('success', 'تمّ حذف الناشر بنجاح');
    }



    public function export(Request $request)
    {
        $query = $this->getQuery($request);

        $export = new PublisherExport();
        $export->setQuery($query->withCount('books'));
        return Excel::download($export, 'publishers.xlsx');
    }
    public function import(Request $request)
    {
        $request->validate(['file' => ['required', 'mimes:xlsx,csv,xls']]);

        $oldCount = Publisher::count();

        Excel::import(new PublisherImport(), $request->file('file'));
        $newCount = Publisher::count();

        $message = $this->buildImportMessage($oldCount, $newCount);

        return redirect()->back()->with('success', $message);
    }

    private function buildImportMessage($oldCount, $newCount)
    {
        $message = '';
        if ($newCount > $oldCount) {
            $imported = $newCount - $oldCount;
            if ($imported == 1) {
                $message = 'تمّ استيراد ناشر واحد بنجاح';
            } else if ($imported > 1 and $imported <= 10) {
                $message = "تمّ استيراد {$imported} ناشرين بنجاح";
            } else {
                $message = "تمّ استيراد {$imported} ناشرا بنجاح";
            }
        } else {
            $message =  'لم يتمّ استيراد أي ناشر من الملفّ. الملفّ خالي من البيانات الفريدة';
        }
        return $message;
    }
    public function filter(Request $request)
    {
        $query = $this->getQuery($request);
        $publishers = $query->withCount('books')->paginate(20);

        if ($request->ajax()) {
            $view = view('admin.components.publishers-results', ['publishers' => $publishers])->render();

            return response()->json([
                'html' => $view
            ]);
        }
        return view('admin.publishers', ['publishers' => $publishers]);
    }

    private function getQuery(Request $request)
    {
        $query = Publisher::query();

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
