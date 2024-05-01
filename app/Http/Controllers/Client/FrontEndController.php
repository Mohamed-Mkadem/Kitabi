<?php

namespace App\Http\Controllers\Client;

use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Admin\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FrontEndController extends Controller
{
    public function index()
    {
        $bestSellingBooks = Book::with('category', 'author', 'publisher')->take(8)->get();

        $latestBooks = Book::with('category', 'author', 'publisher')->latest()->take(8)->get();

        return view('client.home', ['bestSellingBooks' => $bestSellingBooks, 'latestBooks' => $latestBooks]);
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
