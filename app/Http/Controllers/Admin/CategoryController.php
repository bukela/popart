<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Listing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function index(): Response
    {
        $categories = Category::with('childrenRecursive')
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return Inertia::render('Admin/Categories/Index', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        Category::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $descendantIds = $category->getAllDescendantIds();
        $allCategoryIds = array_merge([$category->id], $descendantIds);
        $listingsCount = Listing::whereIn('category_id', $allCategoryIds)->count();

        if ($listingsCount > 0) {
            Listing::whereIn('category_id', $allCategoryIds)->delete();
        }

        if (!empty($descendantIds)) {
            Category::whereIn('id', $descendantIds)->delete();
        }

        $category->delete();

        $message = $listingsCount > 0
            ? "Category and all subcategories deleted successfully. {$listingsCount} listing(s) were soft deleted."
            : 'Category and all subcategories deleted successfully.';

        return redirect()
            ->route('admin.categories.index')
            ->with('success', $message);
    }
}
