<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tax_code',
        'name',
        'address',
        'phone',
        'email',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
