<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\BookOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Notifications\Client\OrderCancelleddNotification;
use App\Notifications\Client\OrderConfirmedNotification;
use App\Notifications\Client\OrderDeliveredNotification;
use App\Notifications\Client\OrderReturnedNotification;
use App\Notifications\Client\OrderShippedNotification;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Order::class);

        $orders = Order::latest()->paginate();

        return view('admin.orders.orders', ['orders' => $orders]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $this->authorize('viewAny', $order);
        $order->load(['books.author', 'books.publisher',  'statusHistories']);
        return view('admin.orders.order', ['order' => $order]);
    }


    public function filter(Request $request)
    {
        $query = Order::query();

        $search = $request->input('search');
        $min_amount = $request->input('min_amount');
        $max_amount = $request->input('max_amount');
        $min_date = $request->input('min_date');
        $max_date = $request->input('max_date');
        $statuses = $request->input('statuses');
        $sort = $request->input('sort');


        if ($search != null) {
            $query->where('id', 'like', "%$search%");
        }
        if ($min_amount != null) {
            $query->where('amount', '>=', ($min_amount * 1000));
        }
        if ($max_amount != null) {
            $query->where('amount', '<=', ($max_amount * 1000));
        }

        if ($min_date != null) {
            $query->where('created_at', '>=', $min_date);
        }
        if ($max_date != null) {
            $maxDateTime = \Carbon\Carbon::parse($max_date)->endOfDay();
            $query->where('created_at', '<=', $maxDateTime);
        }

        if ($statuses != null) {
            $query->whereIn('status', $statuses);
        }

        if ($sort == 'newest') {
            $query->orderBy('created_at', 'desc');
        }

        if ($sort == 'oldest') {
            $query->orderBy('created_at', 'asc');
        }
        if ($sort == 'highest_amount') {
            $query->orderBy('amount', 'desc');
        }
        if ($sort == 'lowest_amount') {
            $query->orderBy('amount', 'asc');
        }

        $orders = $query->paginate();
        return view('admin.orders.orders', ['orders' =>  $orders]);
    }





    public function confirm(Order $order)
    {
        $this->authorize('update', $order);

        if ($order->status != 'pending') {

            return redirect()->back()->with('error', 'لا يمكن تأكيد طلب ليس في حالة الإنتظار');
        }
        $order->update([
            'status' => 'confirmed'
        ]);
        $order->user->notify(new OrderConfirmedNotification($order));
        $this->attachStatusHistoryToOrder($order, 'order confirmed');

        return redirect()->back()->with('success', 'تمّ تأكيد الطلب بنجاح');
    }
    public function cancel(Order $order)
    {
        $this->authorize('update', $order);

        if ($order->status == 'cancelled') {

            return redirect()->back()->with('error', 'هذا الطلب ملغيّ بالفعل');
        }
        DB::beginTransaction();
        $order->update([
            'status' => 'cancelled'
        ]);
        $this->incrementBookQuantities($order);
        db::commit();
        $order->user->notify(new OrderCancelleddNotification($order));
        $this->attachStatusHistoryToOrder($order, 'order cancelled');

        return redirect()->back()->with('success', 'تمّ إلغاء الطلب بنجاح');
    }
    public function ship(Order $order)
    {
        $this->authorize('update', $order);

        if ($order->status != 'confirmed') {

            return redirect()->back()->with('error', 'لا يمكن تأكيد شحن طلب لم يتمّ تأكيده');
        }
        $order->update([
            'status' => 'shipped'
        ]);
        $order->user->notify(new OrderShippedNotification($order));
        $this->attachStatusHistoryToOrder($order, 'order shipped');

        return redirect()->back()->with('success', 'تمّ تأكيد شحن هذاالطلب بنجاح');
    }
    public function deliver(Order $order)
    {
        $this->authorize('update', $order);

        if ($order->status != 'shipped') {

            return redirect()->back()->with('error', 'لا يمكن تأكيد استلام طلب لم يتمّ شحنه');
        }
        $order->update([
            'status' => 'delivered'
        ]);
        $order->user->notify(new OrderDeliveredNotification($order));
        $this->attachStatusHistoryToOrder($order, 'order delivered');

        return redirect()->back()->with('success', 'تمّ تأكيد استلام هذاالطلب بنجاح');
    }
    public function return(Order $order)
    {
        $this->authorize('update', $order);

        if ($order->status != 'shipped') {

            return redirect()->back()->with('error', 'لا يمكن تأكيد إرجاع طلب لم يتمّ شحنه');
        }
        $order->update([
            'status' => 'returned'
        ]);
        $order->user->notify(new OrderReturnedNotification($order));
        $this->attachStatusHistoryToOrder($order, 'order returned');

        return redirect()->back()->with('success', 'تمّ تأكيد إرجاع هذاالطلب بنجاح');
    }

    private function attachStatusHistoryToOrder($order, $action)
    {
        $order->statusHistories()->create([
            'statusable_type' => 'App\Models\Order',
            'statusable_id' => $order->id,
            'action' => $action
        ]);
    }

    private function incrementBookQuantities($order)
    {
        // Retrieve order items associated with the canceled order
        $orderItems = BookOrder::where('order_id', $order->id)->get();

        // Increment the quantities of the associated books
        foreach ($orderItems as $orderItem) {
            $book = $orderItem->book;
            $book->quantity += $orderItem->quantity;
            $book->save();
        }
    }
}
