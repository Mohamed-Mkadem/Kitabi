<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['shipping_cost'];

    public static function getShippingCost()
    {
        $setting = self::first();

        return $setting  ?   $setting->shipping_cost : 7;
    }
}
