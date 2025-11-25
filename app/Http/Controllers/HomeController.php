<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $listings = Listing::with(['category:id,name,slug'])
            ->where('status', 'active')
            ->latest()
            ->paginate(10);

        return Inertia::render(
            'Welcome',
            [
                'listings' => $listings,
            ]
        );
    }
}
