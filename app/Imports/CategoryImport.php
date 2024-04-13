<?php

namespace App\Imports;

use App\Models\Admin\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoryImport implements ToModel, WithHeadingRow
{
    protected $categories;

    public function __construct()
    {
        $this->categories = Category::pluck('name')->toArray();
    }

    public function model(array $row)
    {

        if (in_array($row['name'], $this->categories)) {
            return null;
        }
        return new Category([
            'name' => $row['name']
        ]);
    }
}
