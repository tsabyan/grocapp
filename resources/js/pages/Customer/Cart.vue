<script setup lang="ts">
import CustomerLayout from '@/layouts/CustomerLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

interface CartItem {
    id: number;
    name: string;
    slug: string;
    price: number;
    unit: string;
    image_url: string | null;
    quantity: number;
    subtotal: number;
    stock: number;
}

interface Props {
    cartItems: CartItem[];
    total: number;
    totalItems: number;
}

const props = defineProps<Props>();

const updateQuantity = async (productId: number, quantity: number) => {
    if (quantity < 1) {
        removeItem(productId);
        return;
    }

    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const response = await fetch('/cart/update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            credentials: 'same-origin',
            body: JSON.stringify({
                product_id: productId,
                quantity,
            }),
        });

        const data = await response.json();

        if (response.ok && data.success) {
            // Reload cart page to show updated quantities
            router.visit('/cart', {
                preserveScroll: true,
            });
        } else {
            alert(data.error || 'Failed to update cart');
        }
    } catch (error) {
        console.error('Error updating cart:', error);
        alert('Failed to update cart');
    }
};

const removeItem = async (productId: number) => {
    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const response = await fetch('/cart/remove', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            credentials: 'same-origin',
            body: JSON.stringify({
                product_id: productId,
            }),
        });

        const data = await response.json();

        if (response.ok && data.success) {
            // Reload cart page to show updated cart
            router.visit('/cart', {
                preserveScroll: true,
            });
        } else {
            alert(data.error || 'Failed to remove item');
        }
    } catch (error) {
        console.error('Error removing item:', error);
        alert('Failed to remove item');
    }
};
</script>

<template>
    <Head title="Shopping Cart" />

    <CustomerLayout>
        <div class="mx-auto max-w-md px-4 py-6">
            <h1 class="mb-6 text-2xl font-bold text-gray-900">Shopping Cart</h1>

            <div v-if="cartItems.length === 0" class="py-12 text-center">
                <p class="mb-4 text-gray-600">Your cart is empty</p>
                <Link
                    href="/"
                    class="inline-block rounded-lg bg-black px-6 py-3 text-base font-medium text-white hover:bg-gray-800"
                >
                    Continue Shopping
                </Link>
            </div>

            <div v-else>
                <!-- Cart Items -->
                <div class="mb-6 space-y-4">
                    <div
                        v-for="item in cartItems"
                        :key="item.id"
                        class="rounded-lg border border-gray-200 bg-white p-4"
                    >
                        <div class="flex gap-4">
                            <Link :href="`/products/${item.slug}`" class="flex-shrink-0">
                                <div
                                    v-if="item.image_url"
                                    class="h-20 w-20 overflow-hidden rounded-lg bg-gray-100"
                                >
                                    <img
                                        :src="item.image_url"
                                        :alt="item.name"
                                        class="h-full w-full object-cover"
                                    />
                                </div>
                                <div
                                    v-else
                                    class="h-20 w-20 rounded-lg bg-gray-100"
                                />
                            </Link>
                            <div class="flex-1">
                                <Link :href="`/products/${item.slug}`">
                                    <h3 class="mb-1 text-sm font-medium text-gray-900">
                                        {{ item.name }}
                                    </h3>
                                </Link>
                                <p class="mb-2 text-sm text-gray-600">
                                    ${{ Number(item.price).toFixed(2) }} / {{ item.unit }}
                                </p>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <button
                                            @click="updateQuantity(item.id, item.quantity - 1)"
                                            class="flex h-8 w-8 items-center justify-center rounded border border-gray-300 bg-white text-gray-700 hover:bg-gray-50"
                                        >
                                            −
                                        </button>
                                        <span class="w-8 text-center text-sm font-medium text-gray-900">
                                            {{ item.quantity }}
                                        </span>
                                        <button
                                            @click="updateQuantity(item.id, item.quantity + 1)"
                                            :disabled="item.quantity >= item.stock"
                                            class="flex h-8 w-8 items-center justify-center rounded border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 disabled:bg-gray-100 disabled:text-gray-400"
                                        >
                                            +
                                        </button>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-semibold text-gray-900">
                                            ${{ Number(item.subtotal).toFixed(2) }}
                                        </p>
                                        <button
                                            @click="removeItem(item.id)"
                                            class="mt-1 text-xs text-red-600 hover:text-red-700"
                                        >
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Summary -->
                <div class="mb-6 rounded-lg border border-gray-200 bg-gray-50 p-4">
                    <div class="mb-2 flex justify-between text-sm text-gray-600">
                        <span>Items ({{ totalItems }})</span>
                        <span>${{ Number(total).toFixed(2) }}</span>
                    </div>
                    <div class="flex justify-between border-t border-gray-200 pt-2">
                        <span class="text-base font-semibold text-gray-900">Total</span>
                        <span class="text-base font-semibold text-gray-900">${{ Number(total).toFixed(2) }}</span>
                    </div>
                </div>

                <!-- Checkout Button -->
                <Link
                    href="/checkout"
                    class="block w-full rounded-lg bg-black px-6 py-3 text-center text-base font-medium text-white hover:bg-gray-800"
                >
                    Proceed to Checkout
                </Link>
            </div>
        </div>
    </CustomerLayout>
</template>
