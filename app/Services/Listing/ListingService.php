<?php

namespace App\Services\Listing;

use App\Models\Listing;

class ListingService
{
    public function getFilteredListings(array $filters = []): mixed
    {
        return Listing::with(['category:id,name,slug'])
            ->active()
            ->search($filters['search'] ?? null)
            ->category($filters['category'] ?? null)
            ->location($filters['location'] ?? null)
            ->priceRange(
                $filters['min_price'] ?? null,
                $filters['max_price'] ?? null
            )
            ->latest()
            ->paginate(12)
            ->withQueryString();
    }
}
