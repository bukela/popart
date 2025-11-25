<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Listing::with(['category:id,name,slug'])
            ->where('status', 'active');

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->input('location') . '%');
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        $listings = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get(['id', 'name', 'slug']);

        return Inertia::render('Welcome', [
            'listings' => $listings,
            'categories' => $categories,
            'filters' => $request->only(['search', 'category', 'location', 'min_price', 'max_price']),
        ]);
    }
}
