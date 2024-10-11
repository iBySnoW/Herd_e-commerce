<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['cart_id', 'product_id', 'quantity'];

    protected $appends = ['name', 'price', 'total', 'image_url'];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getNameAttribute()
    {
        return $this->product->name;
    }

    public function getPriceAttribute()
    {
        return $this->product->price;
    }

    public function getTotalAttribute()
    {
        return $this->quantity * $this->product->price;
    }

    public function getImageUrlAttribute()
    {
        return $this->product->image_url ?? '';
    }
}

