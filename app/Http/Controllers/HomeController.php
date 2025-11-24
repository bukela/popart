<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    public function index()
    {
        return Listing::with(['category', 'user'])
            ->where('status', 'active')
            ->latest()
            ->paginate(10);
    }
}
