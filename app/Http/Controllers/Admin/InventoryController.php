<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateStockRequest;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class InventoryController extends Controller
{
    public function index(Request $request): Response
    {
        $product = null;
        $stockMovements = collect();

        if ($request->has('product_id') && $request->product_id) {
            $product = Product::with('category')->findOrFail($request->product_id);
            $stockMovements = StockMovement::where('product_id', $product->id)
                ->latest('created_at')
                ->limit(20)
                ->get();
        }

        $products = Product::with('category')->orderBy('name')->get();

        return Inertia::render('Admin/Inventory/Index', [
            'products' => $products,
            'selectedProduct' => $product,
            'stockMovements' => $stockMovements,
        ]);
    }

    public function updateStock(UpdateStockRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $product = Product::findOrFail($data['product_id']);

        // Update product stock
        $product->increment('stock', $data['change']);

        // Create stock movement record
        StockMovement::create([
            'product_id' => $product->id,
            'change' => $data['change'],
            'reason' => $data['reason'],
            'created_at' => now(),
        ]);

        return redirect()->route('admin.inventory.index', ['product_id' => $product->id])
            ->with('success', 'Stock updated successfully.');
    }
}
