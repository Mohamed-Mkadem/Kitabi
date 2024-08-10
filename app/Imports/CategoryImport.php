<?php

namespace App\Imports;

use App\Models\Admin\Category;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CategoryImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
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

    public function rules(): array
    {
        return [
            'name' => ['required', 'string']
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'name' => "حقل الإسم إحباري"
        ];
    }
}
