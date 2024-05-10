<?php

namespace App\Http\Controllers\Client;

use App\Models\Order;
use App\Models\Admin\Book;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreOrderRequest;
use Exception;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->with(['books'])->paginate();
        return view('client.orders.orders', ['orders' => $orders]);
    }

    public function store(StoreOrderRequest $request)
    {
        $cart = json_decode($request->cart);
        $amount = $this->getAmount($cart);

        try {
            DB::beginTransaction();
            $order = new Order([
                'user_id' => $request->user()->id,
                'amount' => $amount,
                'no_of_items' => count($cart),
                'note' => $request->note,
                'customer_name' => $request->first_name . " " . $request->last_name,
                'shipping_cost' => $request->shipping_cost,
                'shipping_address' => $request->address,
                'customer_phone' => $request->phone,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
            ]);

            $order->save();
            $this->attachBooks($order, $cart);
            $this->deductProductsQuantities($cart);
            $this->attachStatusHistory($order);
            DB::commit();

            return redirect()->route('client.orders.show', $order)->with('success', 'تمّ استلام الطلب بنجاح');
        } catch (\Throwable $th) {
            Db::rollBack();
            throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    public function show(Order $order)
    {
        $this->authorize('view', $order);
        $order->load(['books.author', 'books.publisher', 'statusHistories']);

        return view('client.orders.order', ['order' => $order]);
    }
    private function getAmount($cart)
    {
        $amount = 0;
        foreach ($cart as $book) {
            $amount += $book->quantity * $book->price;
        }
        return $amount;
    }

    private function deductProductsQuantities($cart)
    {
        foreach ($cart as $item) {
            $book = Book::findOrFail($item->productId);
            $book->quantity = DB::raw('quantity - ' . $item->quantity);
            $book->save();
        }
    }

    private function attachBooks(Order $order, $cart)
    {
        foreach ($cart as $book) {
            $order->books()->attach($book->productId, [
                'quantity' => $book->quantity,
                'price' => $book->price,
                'image' => $book->imageUrl,
                'sub_total' => $book->quantity * $book->price
            ]);
        }
    }

    private function attachStatusHistory($order)
    {
        $order->statusHistories()->create([
            'statusable_id' => $order->id,
            'statusable_type' => 'App\Models\Order',
            'action' => 'order created'
        ]);
    }
}
