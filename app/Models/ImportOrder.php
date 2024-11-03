<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ware_house_id',
        'supplier_id',
        'total',
        'price_paid',
        'still_in_debt',
        'date_added',
        'note',
        'status',
    ];

    public function warehouse()
    {
        return $this->belongsTo(WareHouse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }


    public function details()
    {
        return $this->hasMany(ImportOrderDetail::class);
    }
}
