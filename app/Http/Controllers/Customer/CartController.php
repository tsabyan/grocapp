<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CartController extends Controller
{
    public function index(): Response
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;
        $totalItems = 0;

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product && $product->is_active) {
                $subtotal = $product->price * $quantity;
                $cartItems[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->price,
                    'unit' => $product->unit,
                    'image_url' => $product->image_url,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                    'stock' => $product->stock,
                ];
                $total += $subtotal;
                $totalItems += $quantity;
            }
        }

        return Inertia::render('Customer/Cart', [
            'cartItems' => $cartItems,
            'total' => $total,
            'totalItems' => $totalItems,
        ]);
    }

    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if (!$product->is_active) {
            return response()->json(['error' => 'Product is not available'], 400);
        }

        if ($request->quantity > $product->stock) {
            return response()->json(['error' => 'Insufficient stock'], 400);
        }

        $cart = session()->get('cart', []);
        $currentQuantity = $cart[$request->product_id] ?? 0;
        $newQuantity = $currentQuantity + $request->quantity;

        if ($newQuantity > $product->stock) {
            return response()->json(['error' => 'Insufficient stock'], 400);
        }

        $cart[$request->product_id] = $newQuantity;
        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'cartCount' => array_sum($cart),
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if (!$product->is_active) {
            return response()->json(['error' => 'Product is not available'], 400);
        }

        if ($request->quantity > $product->stock) {
            return response()->json(['error' => 'Insufficient stock'], 400);
        }

        $cart = session()->get('cart', []);
        $cart[$request->product_id] = $request->quantity;
        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'cartCount' => array_sum($cart),
        ]);
    }

    public function remove(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $cart = session()->get('cart', []);
        unset($cart[$request->product_id]);
        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'cartCount' => array_sum($cart),
        ]);
    }
}
