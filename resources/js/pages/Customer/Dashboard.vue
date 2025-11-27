<script setup lang="ts">
import CustomerLayout from '@/layouts/CustomerLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { logout } from '@/routes';
import { LogOut, Settings } from 'lucide-vue-next';

interface OrderItem {
    id: number;
    quantity: number;
    unit_price: number;
    subtotal: number;
    product: {
        id: number;
        name: string;
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
    user: {
        name: string;
        email: string;
    };
    orders: {
        data: Order[];
        links: any[];
        current_page: number;
        last_page: number;
    };
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

const handleLogout = () => {
    router.post(logout().url, {}, {
        onFinish: () => {
            router.visit('/');
        },
    });
};
</script>

<template>
    <Head title="Dashboard" />

    <CustomerLayout>
        <div class="mx-auto max-w-md px-4 py-6">
            <h1 class="mb-6 text-2xl font-bold text-gray-900">My Account</h1>

            <!-- Profile Summary -->
            <div class="mb-6 rounded-lg border border-gray-200 bg-white p-4">
                <h2 class="mb-3 text-lg font-semibold text-gray-900">Profile</h2>
                <div class="space-y-2 text-sm">
                    <div>
                        <span class="text-gray-600">Name:</span>
                        <span class="ml-2 font-medium text-gray-900">{{ user.name }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Email:</span>
                        <span class="ml-2 font-medium text-gray-900">{{ user.email }}</span>
                    </div>
                </div>
            </div>

            <!-- Account Actions -->
            <div class="mb-6 rounded-lg border border-gray-200 bg-white p-4">
                <h2 class="mb-3 text-lg font-semibold text-gray-900">Account</h2>
                <div class="space-y-2">
                    <Link
                        href="/settings/profile"
                        class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50"
                    >
                        <Settings class="h-5 w-5" />
                        <span>Edit Profile</span>
                    </Link>
                    <Link
                        href="/settings/password"
                        class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span>Change Password</span>
                    </Link>
                    <button
                        @click="handleLogout"
                        class="flex w-full items-center gap-3 rounded-lg px-4 py-3 text-left text-sm font-medium text-red-600 hover:bg-red-50"
                    >
                        <LogOut class="h-5 w-5" />
                        <span>Logout</span>
                    </button>
                </div>
            </div>

            <!-- Orders List -->
            <div>
                <h2 class="mb-3 text-lg font-semibold text-gray-900">My Orders</h2>
                <div v-if="orders.data.length === 0" class="py-8 text-center text-gray-600">
                    <p>You haven't placed any orders yet.</p>
                </div>
                <div v-else class="space-y-4">
                    <Link
                        v-for="order in orders.data"
                        :key="order.id"
                        :href="`/orders/${order.id}`"
                        class="block rounded-lg border border-gray-200 bg-white p-4 hover:shadow-md"
                    >
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="mb-2 flex items-center gap-2">
                                    <span class="text-sm font-medium text-gray-900">Order #{{ order.id }}</span>
                                    <span
                                        :class="getStatusColor(order.status)"
                                        class="rounded-full px-2 py-1 text-xs font-medium capitalize"
                                    >
                                        {{ order.status }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600">
                                    {{ new Date(order.created_at).toLocaleDateString() }}
                                </p>
                                <p class="mt-1 text-sm font-semibold text-gray-900">
                                    ${{ Number(order.total_price).toFixed(2) }}
                                </p>
                            </div>
                        </div>
                    </Link>
                </div>

                <!-- Pagination -->
                <div v-if="orders.last_page > 1" class="mt-6 flex justify-center gap-2">
                    <button
                        v-if="orders.current_page > 1"
                        @click="$inertia.get(`/dashboard?page=${orders.current_page - 1}`)"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                    >
                        Previous
                    </button>
                    <span class="px-4 py-2 text-sm text-gray-600">
                        Page {{ orders.current_page }} of {{ orders.last_page }}
                    </span>
                    <button
                        v-if="orders.current_page < orders.last_page"
                        @click="$inertia.get(`/dashboard?page=${orders.current_page + 1}`)"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                    >
                        Next
                    </button>
                </div>
            </div>
        </div>
    </CustomerLayout>
</template>
