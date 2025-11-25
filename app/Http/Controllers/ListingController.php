<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListingRequest;
use App\Models\Category;
use App\Models\Listing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ListingController extends Controller
{
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
     * Show the form for creating a new listing.
     */
    public function create(): Response
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();

        return Inertia::render('Listings/Create', [
            'categories' => $categories,
        ]);
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

        return redirect()->route('profile.listings')->with('success', 'Listing created successfully.');
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
        // Ensure user owns the listing
        if ($listing->user_id !== auth()->id()) {
            abort(403);
        }

        $categories = Category::with('children')->whereNull('parent_id')->get();

        return Inertia::render('Listings/Edit', [
            'listing' => $listing,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Listing $listing): RedirectResponse
    {
        if ($listing->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'condition' => 'required|in:new,used',
            'picture' => 'nullable|image|max:2048',
            'contact_phone' => 'required|string|max:20',
            'location' => 'required|string|max:255',
            'status' => 'required|in:active,sold,inactive',
        ]);

        if ($request->hasFile('picture')) {
            if ($listing->picture) {
                Storage::disk('public')->delete($listing->picture);
            }
            $validated['picture'] = $request->file('picture')->store('listings', 'public');
        }

        $listing->update($validated);

        return redirect()->route('profile.listings')->with('success', 'Listing updated successfully.');
    }

    public function destroy(Listing $listing): RedirectResponse
    {
        if ($listing->user_id !== auth()->id()) {
            abort(403);
        }

        if ($listing->picture) {
            Storage::disk('public')->delete($listing->picture);
        }

        $listing->delete();

        return redirect()->route('profile.listings')->with('success', 'Listing deleted successfully.');
    }
}
