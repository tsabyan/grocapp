<script setup lang="ts">
import CustomerLayout from '@/layouts/CustomerLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

interface OrderItem {
    id: number;
    quantity: number;
    unit_price: number;
    subtotal: number;
    product: {
        id: number;
        name: string;
        unit: string;
    };
}

interface Order {
    id: number;
    customer_name: string;
    customer_phone: string;
    delivery_address: string;
    status: string;
    total_price: number;
    created_at: string;
    order_items: OrderItem[];
}

interface Props {
    order: Order;
}

const props = defineProps<Props>();

const getStatusColor = (status: string) => {
    const colors: Record<string, string> = {
        pending: 'bg-yellow-100 text-yellow-800',
        confirmed: 'bg-blue-100 text-blue-800',
        delivered: 'bg-green-100 text-green-800',
        cancelled: 'bg-red-100 text-red-800',
    };
    return colors[status] || 'bg-gray-100 text-gray-800';
};
</script>

<template>
    <Head :title="`Order #${order.id}`" />

    <CustomerLayout>
        <div class="mx-auto max-w-md px-4 py-6">
            <!-- Thank You Message -->
            <div class="mb-6 text-center">
                <h1 class="mb-2 text-2xl font-bold text-gray-900">Thank You!</h1>
                <p class="text-gray-600">Your order has been placed successfully</p>
            </div>

            <!-- Order Summary -->
            <div class="mb-6 rounded-lg border border-gray-200 bg-white p-4">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Order #{{ order.id }}</h2>
                    <span
                        :class="getStatusColor(order.status)"
                        class="rounded-full px-3 py-1 text-xs font-medium capitalize"
                    >
                        {{ order.status }}
                    </span>
                </div>
                <p class="mb-4 text-sm text-gray-600">
                    Placed on {{ new Date(order.created_at).toLocaleString() }}
                </p>

                <!-- Order Items -->
                <div class="mb-4 border-t border-gray-200 pt-4">
                    <h3 class="mb-3 text-sm font-semibold text-gray-900">Items</h3>
                    <div class="space-y-2">
                        <div
                            v-for="item in order.order_items"
                            :key="item.id"
                            class="flex justify-between text-sm"
                        >
                            <span class="text-gray-600">
                                {{ item.product.name }} × {{ item.quantity }} {{ item.product.unit }}
                            </span>
                            <span class="font-medium text-gray-900">${{ Number(item.subtotal).toFixed(2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Delivery Info -->
                <div class="mb-4 border-t border-gray-200 pt-4">
                    <h3 class="mb-2 text-sm font-semibold text-gray-900">Delivery Information</h3>
                    <div class="space-y-1 text-sm text-gray-600">
                        <p><span class="font-medium">Name:</span> {{ order.customer_name }}</p>
                        <p><span class="font-medium">Phone:</span> {{ order.customer_phone }}</p>
                        <p><span class="font-medium">Address:</span> {{ order.delivery_address }}</p>
                    </div>
                </div>

                <!-- Total -->
                <div class="border-t border-gray-200 pt-4">
                    <div class="flex justify-between">
                        <span class="text-base font-semibold text-gray-900">Total</span>
                        <span class="text-base font-semibold text-gray-900">${{ Number(order.total_price).toFixed(2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="space-y-3">
                <Link
                    href="/dashboard"
                    class="block w-full rounded-lg border border-gray-300 bg-white px-6 py-3 text-center text-base font-medium text-gray-700 hover:bg-gray-50"
                >
                    View All Orders
                </Link>
                <Link
                    href="/"
                    class="block w-full rounded-lg bg-black px-6 py-3 text-center text-base font-medium text-white hover:bg-gray-800"
                >
                    Continue Shopping
                </Link>
            </div>
        </div>
    </CustomerLayout>
</template>
