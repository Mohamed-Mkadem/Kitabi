<?php

namespace App\Imports;

use App\Models\Admin\Book;
use App\Models\Admin\Author;
use App\Models\Admin\Category;
use App\Models\Admin\Publisher;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class BookImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{

    protected $authors;
    protected $publishers;
    protected $categories;
    protected $books;

    public function __construct()
    {
        $this->authors = Author::pluck('id', 'name')->toArray();
        $this->categories = Category::pluck('id', 'name')->toArray();
        $this->publishers = Publisher::pluck('id', 'name')->toArray();
        $this->books = Book::pluck('name')->toArray();
    }
    public function model(array $row)
    {
        if (in_array($row['name'], $this->books)) {
            return null;
        }

        return new Book([
            'name' => $row['name'],
            'status' => $row['status'],
            'category_id' => $this->getCategoryId($row['category']),
            'publisher_id' => $this->getPublisherId($row['publisher']),
            'author_id' => $this->getAuthorId($row['author']),
            'price' => $row['price'],
            'quantity' => $row['quantity'],
            'stock_alert' => $row['stock_alert'],
            'cost_price' => $row['cost_price'],
            'description' => $row['description'],
            'image' => $row['image'],
        ]);
    }


    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'image' => ['required', 'string'],
            'status' => ['required', 'in:published,hidden'],
            'category' => ['required'],
            'publisher' => ['required'],
            'author' => ['required'],
            'cost_price' => ['required', 'numeric', 'integer', 'min:100'],
            'price' => ['required', 'numeric', 'integer', 'min:100', 'gt:*.cost_price'],
            'quantity' => ['required', 'numeric', 'integer', 'min:0'],
            'stock_alert' => ['required', 'numeric', 'integer', 'min:0'],
            'description' => ['required', 'string'],
        ];
    }


    public function customValidationMessages()
    {
        return [
            'price.gt' => 'يجب أن تكون قيمة سعر البيع أكير من قيمة سعر التكلفة',

        ];
    }
    public function customValidationAttributes()
    {
        return [
            'author' => 'المؤلّف',
            'category' => 'التصنيف',
            'publisher' => 'دار النشر',
            'cost_price' => 'سعر التكلفة',
            'stock_alert' => 'كمّيّة التنبيه',
            'price' => 'السعر',
            'image' => 'الصورة',
            'quantity' => 'الكمّيّة',
            'status' => 'الحالة',
            'description' => '"الوصف"'
        ];
    }

    private function createAuthor($name)
    {
        $author = Author::create(['name' => $name]);
        return $author->id;
    }
    private function getAuthorId($name)
    {
        if (array_key_exists($name, $this->authors)) {
            return $this->authors[$name];
        }

        $id = $this->createAuthor($name);
        $this->authors[$name] = $id;
        return $id;
    }
    private function createPublisher($name)
    {
        $publisher = Publisher::create(['name' => $name]);
        return $publisher->id;
    }
    private function getPublisherId($name)
    {
        if (array_key_exists($name, $this->publishers)) {
            return $this->publishers[$name];
        }

        $id = $this->createPublisher($name);
        $this->publishers[$name] = $id;
        return $id;
    }
    private function createCategory($name)
    {
        $category = Category::create(['name' => $name]);
        return $category->id;
    }
    private function getCategoryId($name)
    {
        if (array_key_exists($name, $this->categories)) {
            return $this->categories[$name];
        }

        $id = $this->createCategory($name);
        $this->categories[$name] = $id;
        return $id;
    }
}
