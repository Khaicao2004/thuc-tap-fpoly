<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'discount_value',
        'start_date',
        'end_date',
        'min_order_value',
        'usage_limit',
        'used',
        'is_active',
        'discount_type',
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
}