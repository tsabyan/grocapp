<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response|RedirectResponse
    {
        $user = auth()->user();

        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        $orders = $user->orders()
            ->with('orderItems.product')
            ->latest()
            ->paginate(10);

        return Inertia::render('Customer/Dashboard', [
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
            'orders' => $orders,
        ]);
    }
}
