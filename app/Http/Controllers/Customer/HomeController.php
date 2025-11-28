<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        $categories = Category::orderBy('name')->get();
        $searchQuery = request()->get('search', '');

        $products = Product::where('is_active', true)
            ->with('category');

        if ($searchQuery) {
            $products->where('name', 'like', '%' . $searchQuery . '%');
        }

        $products = $products->latest()->paginate(12);

        return Inertia::render('Customer/Home', [
            'categories' => $categories,
            'featuredProducts' => $products,
            'searchQuery' => $searchQuery,
        ]);
    }
}
