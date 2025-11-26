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
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeSearch($query, $term)
    {
        if (empty($term)) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%");
        });
    }

    public function scopeCategory($query, $categoryId)
    {
        if (empty($categoryId)) {
            return $query;
        }

        $category = Category::find($categoryId);
        if (!$category) {
            return $query;
        }

        $categoryIds = $category->getAllDescendantIds();
        $categoryIds[] = $category->id;

        return $query->whereIn('category_id', $categoryIds);
    }

    public function scopeLocation($query, $location)
    {
        if (empty($location)) {
            return $query;
        }

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
}
