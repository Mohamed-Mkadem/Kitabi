<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;

class SettingController extends Controller
{
    public function setShippingCost(Request $request)
    {
        $request->validate([
            'shipping_cost' => ['required', 'numeric', 'min:1']
        ], [
            'shipping_cost.min' => 'قيمة تكلفة الشحن يجب أن تكون على الأقلّ 1 دينار'
        ]);

        $setting = Setting::first();
        if ($setting) {
            $setting->shipping_cost = $request->shipping_cost;
            $setting->save();
        } else {
            Setting::create([
                'shipping_cost' => $request->shipping_cost
            ]);
        }

        return redirect()->back()->with('success', 'تمّ تعديل تكلفة الشحن');
    }
}
