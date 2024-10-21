<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'catalogue_id',
        'ware_house_id',
        'name',
        'slug',
        'sku',
        'img_thumbnail',
        'price_regular',
        'price_sale',
        'description',
        'content',
        'material',
        'user_manual',
        'views',
        'is_active',
        'is_hot_deal',
        'is_good_deal',
        'is_new',
        'is_show_home',
    ];
    protected $casts = [
        'is_active' => 'boolean',
        'is_hot_deal' => 'boolean',
        'is_good_deal' => 'boolean',
        'is_new' => 'boolean',
        'is_show_home' => 'boolean',
    ];
    public function catalogue()
    {
        return $this->belongsTo(Catalogue::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function galleries()
    {
        return $this->hasMany(ProductGallery::class);
    }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    public function warehouse()
    {
        return $this->belongsTo(WareHouse::class);
    }
    public function coupons()
    {
        return $this->belongsToMany(Coupon::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Thêm các thuộc tính ảo để IDE không báo lỗi
    protected $appends = ['averageRating', 'ratingCount'];

    /**
     * Truy cập thuộc tính ảo averageRating
     */
    public function getAverageRatingAttribute()
    {
        return $this->attributes['averageRating'] ?? $this->comments()->avg('rating');
    }

    /**
     * Truy cập thuộc tính ảo ratingCount
     */
    public function getRatingCountAttribute()
    {
        return $this->attributes['ratingCount'] ?? $this->comments()->count();
    }
}
