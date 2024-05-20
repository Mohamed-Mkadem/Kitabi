<?php

namespace App\Http\Controllers\Client;

use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Admin\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class FrontEndController extends Controller
{
    public function index()
    {
        // $bestSellingBooks = Book::with('category', 'author', 'publisher', 'orderItems')->withSum('orderItems', 'quantity')->orderBy('order_items_sum_quantity', 'desc')->take(8)->get();


        // $latestBooks = Book::with('category', 'author', 'publisher')->latest()->take(8)->get();

        // return view('client.home', ['bestSellingBooks' => $bestSellingBooks, 'latestBooks' => $latestBooks]);


        $oneDayInSeconds = 60 * 60 * 24;
        $bestSellingBooks = Cache::remember('bestSellingBooks', $oneDayInSeconds, function () {
            return Book::with(['category', 'author', 'publisher'])
                ->withSum('orderItems', 'quantity')
                ->orderBy('order_items_sum_quantity', 'desc')
                ->take(8)
                ->get();
        });


        $latestBooks = Cache::remember('latestBooks', $oneDayInSeconds, function () {
            return Book::with(['category', 'author', 'publisher'])
                ->latest()
                ->take(8)
                ->get();
        });


        return view('client.home', compact('bestSellingBooks', 'latestBooks'));
    }

    public function cart()
    {
        return view('client.cart');
    }
    public function checkout()
    {

        $user = User::select('first_name', 'last_name', 'address', 'phone', 'city_id', 'state_id')->find(Auth::id());


        $states = State::all();
        $cities = City::all();


        $shippingCost = 7;

        return view('client.checkout', compact('user', 'states', 'cities', 'shippingCost'));
    }
}
