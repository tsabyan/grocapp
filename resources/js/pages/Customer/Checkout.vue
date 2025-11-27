<script setup lang="ts">
import CustomerLayout from '@/layouts/CustomerLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';

interface CartItem {
    id: number;
    name: string;
    price: number;
    unit: string;
    quantity: number;
    subtotal: number;
}

interface Props {
    cartItems: CartItem[];
    total: number;
}

const props = defineProps<Props>();

const form = useForm({
    customer_name: '',
    customer_phone: '',
    delivery_address: '',
    payment_method: 'cash',
});

const submit = () => {
    form.post('/checkout', {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Checkout" />

    <CustomerLayout>
        <div class="mx-auto max-w-md px-4 py-6">
            <h1 class="mb-6 text-2xl font-bold text-gray-900">Checkout</h1>

            <!-- Order Summary -->
            <div class="mb-6 rounded-lg border border-gray-200 bg-gray-50 p-4">
                <h2 class="mb-3 text-lg font-semibold text-gray-900">Order Summary</h2>
                <div class="space-y-2">
                    <div
                        v-for="item in cartItems"
                        :key="item.id"
                        class="flex justify-between text-sm text-gray-600"
                    >
                        <span>{{ item.name }} × {{ item.quantity }}</span>
                        <span>${{ Number(item.subtotal).toFixed(2) }}</span>
                    </div>
                </div>
                <div class="mt-3 flex justify-between border-t border-gray-200 pt-3">
                    <span class="text-base font-semibold text-gray-900">Total</span>
                    <span class="text-base font-semibold text-gray-900">${{ Number(total).toFixed(2) }}</span>
                </div>
            </div>

            <!-- Checkout Form -->
            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <label for="customer_name" class="mb-1 block text-sm font-medium text-gray-700">
                        Full Name *
                    </label>
                    <input
                        id="customer_name"
                        v-model="form.customer_name"
                        type="text"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900 focus:border-black focus:outline-none focus:ring-1 focus:ring-black"
                    />
                    <p v-if="form.errors.customer_name" class="mt-1 text-sm text-red-600">
                        {{ form.errors.customer_name }}
                    </p>
                </div>

                <div>
                    <label for="customer_phone" class="mb-1 block text-sm font-medium text-gray-700">
                        Phone Number *
                    </label>
                    <input
                        id="customer_phone"
                        v-model="form.customer_phone"
                        type="tel"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900 focus:border-black focus:outline-none focus:ring-1 focus:ring-black"
                    />
                    <p v-if="form.errors.customer_phone" class="mt-1 text-sm text-red-600">
                        {{ form.errors.customer_phone }}
                    </p>
                </div>

                <div>
                    <label for="delivery_address" class="mb-1 block text-sm font-medium text-gray-700">
                        Delivery Address *
                    </label>
                    <textarea
                        id="delivery_address"
                        v-model="form.delivery_address"
                        rows="4"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900 focus:border-black focus:outline-none focus:ring-1 focus:ring-black"
                    />
                    <p v-if="form.errors.delivery_address" class="mt-1 text-sm text-red-600">
                        {{ form.errors.delivery_address }}
                    </p>
                </div>

                <div>
                    <label for="payment_method" class="mb-1 block text-sm font-medium text-gray-700">
                        Payment Method *
                    </label>
                    <select
                        id="payment_method"
                        v-model="form.payment_method"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900 focus:border-black focus:outline-none focus:ring-1 focus:ring-black"
                    >
                        <option value="cash">Cash on Delivery</option>
                        <option value="card">Card</option>
                        <option value="online">Online Payment</option>
                    </select>
                    <p v-if="form.errors.payment_method" class="mt-1 text-sm text-red-600">
                        {{ form.errors.payment_method }}
                    </p>
                </div>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full rounded-lg bg-black px-6 py-3 text-base font-medium text-white hover:bg-gray-800 disabled:bg-gray-300"
                >
                    {{ form.processing ? 'Placing Order...' : 'Place Order' }}
                </button>
            </form>
        </div>
    </CustomerLayout>
</template>
