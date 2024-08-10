<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function home()
    {
        $counts = $this->getStatistics();
        $shippingCost = Setting::getShippingCost();
        $orders = Order::with('user')->latest()->take(5)->get();
        return view('admin.home', compact('counts', 'shippingCost', 'orders'));
    }

    private function getStatistics()
    {
        return [
            'notifications' => Auth::user()->notifications()->whereBetween('created_at', [
                Carbon::today()->startOfDay(), Carbon::today()->endOfDay()
            ])->count(),
            'orders' => Order::whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])->count(),
            'users' => User::whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])->count(),
            'reviews' => Review::whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])->count(),
        ];
    }
}
