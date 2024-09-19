<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Catalogue extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'parent_id',
        'cover',
        'is_active',
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];
    public function parent(){
        return $this->belongsTo(Catalogue::class, 'parent_id');
    }
    public function children(){
        return $this->hasMany(Catalogue::class, 'parent_id');
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}
