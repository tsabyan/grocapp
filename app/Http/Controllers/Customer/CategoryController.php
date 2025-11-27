<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function index(): Response
    {
        $categories = Category::withCount(['products' => function ($query) {
            $query->where('is_active', true);
        }])->orderBy('name')->get();

        return Inertia::render('Customer/Categories', [
            'categories' => $categories,
        ]);
    }

    public function show(string $slug): Response
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $products = Product::where('category_id', $category->id)
            ->where('is_active', true)
            ->with('category')
            ->paginate(12)
            ->withQueryString();

        return Inertia::render('Customer/CategoryProducts', [
            'category' => $category,
            'products' => $products,
        ]);
    }
}
