<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/category-test', function () {
    //$categories = \App\Models\Category::with('childrenRecursive')->whereNull('parent_id')->get();
    $categories = \App\Models\Category::select(['id', 'name', 'slug', 'parent_id'])
        ->with('childrenRecursive')
        ->whereNull('parent_id')
        ->orderBy('name')
        ->get();
    return response()->json($categories);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ListingController::class, 'index'])->name('profile.listings');

    Route::get('/listings/create', [ListingController::class, 'create'])->name('listings.create');
    Route::post('/listings', [ListingController::class, 'store'])->name('listings.store');
    Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->name('listings.edit');
    Route::put('/listings/{listing}', [ListingController::class, 'update'])->name('listings.update');
    Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->name('listings.destroy');

    Route::get('/profile/settings', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/settings', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/settings', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('listings.show');

require __DIR__ . '/auth.php';
