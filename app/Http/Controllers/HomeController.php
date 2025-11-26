<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListingFilterRequest;
use App\Models\Category;
use App\Services\Listing\ListingService;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __construct(private ListingService $listingService)
    {}

    public function index(ListingFilterRequest $request)
    {
        $validated = $request->validated();
        $listings = $this->listingService->getFilteredListings($validated);
        $categories = Category::select(['id', 'name', 'slug', 'parent_id'])
            ->with('childrenRecursive')
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return Inertia::render('Home', [
            'listings' => $listings,
            'categories' => $categories,
            'filters' => $validated,
        ]);
    }
}
