<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id',
        'image_url',
        'item_state',
        'item_name',
        'item_brand',
        'item_description',
        'item_amount',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_item');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isLiked($user_id)
    {
        return $this->likes()->where('user_id', $user_id)->exists();
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function isSold()
    {
        return $this->order()->exists();
    }
}
