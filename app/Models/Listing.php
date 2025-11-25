<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Listing extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'price',
        'condition',
        'picture',
        'contact_phone',
        'location',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * Get the user that owns the listing.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that owns the listing.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeSearch($query, $term)
    {
        if (empty($term)) return $query;

        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%");
        });
    }

    public function scopeCategory($query, $categoryId)
    {
        if (empty($categoryId)) return $query;

        return $query->where('category_id', $categoryId);
    }

    public function scopeLocation($query, $location)
    {
        if (empty($location)) return $query;

        return $query->where('location', 'like', "%{$location}%");
    }

    public function scopePriceRange($query, $minPrice, $maxPrice)
    {
        if (!empty($minPrice)) {
            $query->where('price', '>=', (float) $minPrice);
        }

        if (!empty($maxPrice)) {
            $query->where('price', '<=', (float) $maxPrice);
        }

        return $query;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
