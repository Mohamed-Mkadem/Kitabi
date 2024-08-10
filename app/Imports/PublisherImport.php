<?php

namespace App\Imports;

use App\Models\Admin\Publisher;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PublisherImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{

    protected $publishers;

    public function __construct()
    {
        $this->publishers = Publisher::pluck('name')->toArray();
    }

    public function model(array $row)
    {
        if (in_array($row['name'], $this->publishers)) return null;

        return new Publisher([
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
