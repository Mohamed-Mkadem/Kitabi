<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'statusable_id',
        'statusable_type',
        'action'
    ];

    public function statusable()
    {
        return $this->morphTo();
    }
}
