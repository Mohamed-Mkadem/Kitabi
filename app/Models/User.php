<?php

namespace App\Models;



use App\Models\City;
use App\Models\Order;
use App\Models\State;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone', 'address', 'state_id', 'city_id', 'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    public function state()
    {
        return $this->belongsTo(State::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }


    public function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => ucfirst($this->first_name) . ' ' . ucfirst($this->last_name)
        );
    }
    public function stateCity(): Attribute
    {
        return Attribute::make(
            get: fn () => ucfirst($this->state->name) . ' - ' . ucfirst($this->city->name)
        );
    }
    public function formattedSpentAmount(): Attribute
    {
        return Attribute::make(
            get: fn () => number_format(($this->orders_sum_amount / 1000), 3)
        );
    }
    public function isAdmin(): bool
    {
        return $this->role == 'admin';
    }
    public function isClient(): bool
    {
        return $this->role == 'user';
    }
    public function isActive(): bool
    {
        return $this->status == 'active';
    }
}
