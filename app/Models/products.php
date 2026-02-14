<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\category;
use App\Models\Offer;
use App\Models\ProductImage;

class products extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'total',
        'Category_id'
    ];

    public function category()
    {
        return $this->belongsTo(category::class, 'Category_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function offer()
    {
        return $this->hasOne(Offer::class, 'product_id');
    }

    /** Whether the product's offer should be shown on the storefront (date range and timezone aware). */
    public function hasVisibleOffer(): bool
    {
        if (!$this->relationLoaded('offer') || !$this->offer) {
            return false;
        }
        $offer = $this->offer;
        $now = now();
        if ($offer->starts_at !== null && $now->lessThan(\Carbon\Carbon::parse($offer->starts_at))) {
            return false;
        }
        if ($offer->ends_at !== null && $now->greaterThan(\Carbon\Carbon::parse($offer->ends_at))) {
            return false;
        }
        return true;
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'product_id');
    }
}
