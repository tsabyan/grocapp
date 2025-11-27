<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function show(Order $order): Response|RedirectResponse
    {
        $user = auth()->user();

        // Ensure user can only view their own orders (unless admin)
        if (!$user->is_admin && $order->user_id !== $user->id) {
            abort(403);
        }

        $order->load('orderItems.product', 'user');

        return Inertia::render('Customer/Order/Show', [
            'order' => $order,
        ]);
    }
}
