<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListingRequest;
use App\Models\Category;
use App\Models\Listing;
use App\Traits\Listing\AdminOrOwner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ListingController extends Controller
{
    use AdminOrOwner;
    /**
     * Display user's listings (Profile page).
     */
    public function index(): Response
    {
        $listings = auth()->user()->listings()->with('category')->latest()->get();

        return Inertia::render('Profile/Index', [
            'listings' => $listings,
        ]);
    }

    /**
     * Display the specified listing.
     */
    public function show(Listing $listing): Response
    {
        $listing->load(['category', 'user']);

        return Inertia::render('Listings/Show', [
            'listing' => $listing,
        ]);
    }

    /**
     * Show the form for editing the specified listing.
     */
    public function edit(Listing $listing): Response
    {
        $this->authorizeListingModification($listing);

        $categories = Category::select(['id', 'name', 'slug', 'parent_id'])
            ->with('childrenRecursive')
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return Inertia::render('Listings/Edit', [
            'listing' => $listing,
            'categories' => $categories,
        ]);
    }

    public function update(ListingRequest $request, Listing $listing): RedirectResponse
    {
        $this->authorizeListingModification($listing);
        $validated = $request->validated();

        if ($request->hasFile('picture')) {
            if ($listing->picture) {
                Storage::disk('public')->delete($listing->picture);
            }
            $validated['picture'] = $request->file('picture')->store('listings', 'public');
        } else {
            unset($validated['picture']);
        }

        $listing->update($validated);

        return redirect()
            ->route('profile.listings')
            ->with('success', 'Listing updated successfully.');
    }

    /**
     * Store a newly created listing in storage.
     */
    public function store(ListingRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('picture')) {
            $validated['picture'] = $request->file('picture')->store('listings', 'public');
        }

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'active';

        Listing::create($validated);

        return redirect()
            ->route('profile.listings')
            ->with('success', 'Listing created successfully.');
    }

    /**
     * Show the form for creating a new listing.
     */
    public function create(): Response
    {
        $categories = Category::select(['id', 'name', 'slug', 'parent_id'])
            ->with('childrenRecursive')
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return Inertia::render('Listings/Create', [
            'categories' => $categories,
        ]);
    }

    public function destroy(Listing $listing): RedirectResponse
    {
        $this->authorizeListingModification($listing);

        if ($listing->picture) {
            Storage::disk('public')->delete($listing->picture);
        }

        $listing->delete();

        return redirect()
            ->route('profile.listings')
            ->with('success', 'Listing deleted successfully.');
    }
}
