<?php

namespace App\Http\Requests\Client;

use App\Models\Admin\Book;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->isActive();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'phone' => ['required',  'numeric', 'digits:8'],
            'address' => ['required', 'string'],
            'state_id' => ['required', 'exists:states,id'],
            'city_id' => [
                'required',
                Rule::exists('cities', 'id')->where(function ($query) {
                    $query->where('state_id', $this->state_id);
                }),
            ],
            'note' => ['nullable', 'string', 'max:1000'],
            'cart' => 'required'
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $cart = json_decode($this->cart, true);

            // Validate that the cart is not empty
            if (empty($cart)) {
                $validator->errors()->add('cart', 'السلّة فارغة');
                return;
            }

            // Validate that all books in the cart exist in the database
            foreach ($cart as $item) {
                $book = Book::find($item['productId']);
                if (!$book) {
                    $validator->errors()->add('cart', 'هذا الكتاب غير موجود:  ' . $item['title']);
                }
            }

            // Validate that quantities of books in the cart are available in the inventory
            foreach ($cart as $item) {
                $book = Book::find($item['productId']);
                if ($book && $book->quantity < $item['quantity']) {
                    $validator->errors()->add('cart', 'الكمّية المتوفرة في مخازننا أقلّ من الكمّية المطلوبة لهذا المنتج: ' . $book->name);
                }
            }
        });
    }
}
