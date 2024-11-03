<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportOrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'import_order_id',
        'product_id',
        'product_variant_id',
        'product_name',
        'quantity',
        'price_import',
        'total_price',
        'date_added',
        'note',
    ];

    public function import_order()
    {
        return $this->belongsTo(ImportOrder::class);
    }

    public function productvariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
    public function poduct()
    {
        return $this->belongsTo(Product::class);
    }
}
