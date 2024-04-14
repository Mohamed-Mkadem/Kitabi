<?php

namespace App\Imports;

use App\Models\Publisher;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PublisherImport implements ToModel, WithHeadingRow
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
}
