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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
