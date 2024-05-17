<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;

class ClientController extends Controller
{
    public function index()
    {
        $clients = User::where('role', 'user')->with(['state', 'city',])->withCount('orders')->withSum('orders', 'amount')->latest()->paginate();

        $states = State::with('cities')->get();

        return view('admin.clients.clients', ['clients' => $clients,  'states' => $states]);
    }

    public function show(User $client)
    {
        $this->authorize('view', $client);

        $client->load([
            'orders.books',
            'state',
            'city',
            'reviews.book.publisher',
            'reviews.book.author'
        ])->loadSum('orders', 'amount')->loadCount('orders', 'reviews');

        $ordersStatusesCounts = $this->getOrderStatusesCounts($client);
        return view('admin.clients.client', ['client' => $client, 'ordersStatusesCounts' => $ordersStatusesCounts]);
    }

    public function ban(User $client)
    {
        $this->authorize('update', $client);

        if (!$client->isActive()) {
            return redirect()->back()->with('error', 'هذا العميل محظور بالفعل');
        }

        $client->update([
            'status' => 'banned'
        ]);
        return redirect()->back()->with('success', 'تمّ حظر العميل بنجاح');
    }
    public function activate(User $client)
    {
        $this->authorize('update', $client);

        if ($client->isActive()) {
            return redirect()->back()->with('error', 'هذا العميل نشط بالفعل');
        }

        $client->update([
            'status' => 'active'
        ]);
        return redirect()->back()->with('success', 'تمّ فكّ الحظر عن هذا العميل بنجاح');
    }

    public function filter(Request $request)
    {
        $query = $this->getQuery($request);

        $clients = $query->with(['state', 'city',])->withCount('orders')->withSum('orders', 'amount')->paginate();
        $states = State::with('cities')->get();

        return view('admin.clients.clients', ['clients' => $clients,  'states' => $states]);
    }


    private function getQuery(Request $request)
    {
        $query = User::query();

        $query->where('role', 'user');

        $search = $request->input('search');
        $sort = $request->input('sort');

        $min_orders = $request->input('min_orders');
        $max_orders = $request->input('max_orders');

        $min_spent = $request->input('min_spent');
        $max_spent = $request->input('max_spent');

        $min_date = $request->input('min_date');
        $max_date = $request->input('max_date');

        $statuses = $request->input('statuses');

        $state_id = $request->input('state_id');
        $city_id = $request->input('city_id');


        if (!empty($min_spent)) {
            $query->havingRaw('COALESCE(orders_sum_amount, 0) >= ?', [$min_spent * 1000]);
        }
        if (!empty($max_spent)) {
            $query->havingRaw('COALESCE(orders_sum_amount, 0) <= ?', [$max_spent * 1000]);
        }


        if ($min_orders != null) {
            $query->having('orders_count', '>=', $min_orders);
        }

        if ($max_orders != null) {
            $query->having('orders_count', '<=', $max_orders);
        }


        if ($search != null) {
            $query->where('first_name', 'like', "%$search%")->orWhere('last_name', 'like', "%$search%");
        }

        if ($statuses != null) {
            $query->whereIn('status', $statuses);
        }

        if ($state_id != 'all') {
            $query->where('state_id', $state_id);
        }

        if ($city_id != 'all') {
            $query->where('city_id', $city_id);
        }

        if ($min_date != null) {
            $query->where('created_at', '>=', $min_date);
        }
        if ($max_date != null) {
            $maxDateTime = \Carbon\Carbon::parse($max_date)->endOfDay();
            $query->where('created_at', '<=', $maxDateTime);
        }

        if ($sort == 'oldest') {
            $query->orderBy('created_at', 'asc');
        }

        if ($sort == 'newest') {
            $query->orderBy('created_at', 'desc');
        }

        if ($sort == 'highest_spent') {
            $query->orderBy('orders_sum_amount', 'desc');
        }
        if ($sort == 'lowest_spent') {
            $query->orderBy('orders_sum_amount', 'asc');
        }

        if ($sort == 'highest_orders') {
            $query->orderBy('orders_count', 'desc');
        }
        if ($sort == 'lowest_orders') {
            $query->orderBy('orders_count', 'asc');
        }


        return $query;
    }


    private function getOrderStatusesCounts($client)
    {
        return [
            'pending' => $client->orders()->where('status', 'pending')->count(),
            'confirmed' => $client->orders()->where('status', 'confirmed')->count(),
            'cancelled' => $client->orders()->where('status', 'cancelled')->count(),
            'delivered' => $client->orders()->where('status', 'delivered')->count(),
            'shipped' => $client->orders()->where('status', 'shipped')->count(),
            'returned' => $client->orders()->where('status', 'returned')->count(),
        ];
    }
}
