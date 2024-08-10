<?php

namespace App\Http\Requests\Admin\Book;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'unique:books,name'],
            // 'image' => ['required', 'image', 'mimes:png,jpg', 'max:2048'],
            'image' => [
                'required', File::image()->types(['png', 'jpg'])->max('2mb')->dimensions(Rule::dimensions()->height(750)->width(500))
            ],
            'status' => ['required', 'in:published,hidden'],
            'category_id' => ['required', 'exists:categories,id'],
            'publisher_id' => ['required', 'exists:publishers,id'],
            'author_id' => ['required', 'exists:authors,id'],
            'cost_price' => ['required', 'numeric', 'integer', 'min:100'],
            'price' => ['required', 'numeric', 'integer', 'min:100', 'gt:cost_price'],
            'quantity' => ['required', 'numeric', 'integer', 'min:0'],
            'stock_alert' => ['required', 'numeric', 'integer', 'min:0'],
            'description' => ['required', 'string'],
        ];
    }


    public function messages()
    {
        return [
            'price.gt' => 'يجب أن تكون قيمة سعر البيع أكير من قيمة سعر التكلفة',
            'image.dimensions' => 'الرجاء رفع صورة بأبعاد 750 * 500'
        ];
    }
    public function attributes()
    {
        return [
            'author_id' => 'المؤلّف',
            'category_id' => 'التصنيف',
            'publisher_id' => 'دار النشر',
            'cost_price' => 'سعر التكلفة',
            'stock_alert' => 'كمّيّة التنبيه',
            'price' => 'السعر',
            'image' => 'الصورة',
            'quantity' => 'الكمّيّة',
            'status' => 'الحالة',
            'description' => 'الوصف'
        ];
    }
}
