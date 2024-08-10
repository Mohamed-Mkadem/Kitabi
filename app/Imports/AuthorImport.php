<?php

namespace App\Imports;

use App\Models\Admin\Author;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AuthorImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    protected $authors;

    public function __construct()
    {
        $this->authors = Author::pluck('name')->toArray();
    }

    public function model(array $row)
    {
        if (in_array($row['name'], $this->authors)) {
            return null;
        }
        return new Author([
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
