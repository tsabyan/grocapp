<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';

interface Props {
    stats: {
        total_categories: number;
        total_products: number;
        total_stock: number;
        total_orders: number;
        orders_by_status: Record<string, number>;
    };
}

defineProps<Props>();
</script>

<template>
    <Head title="Admin Dashboard" />

    <AdminLayout>
        <div class="space-y-6">
            <h2 class="text-2xl font-bold text-gray-900">Dashboard</h2>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-lg border border-gray-200 bg-white p-6">
                    <div class="text-sm font-medium text-gray-500">Total Categories</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">
                        {{ stats.total_categories }}
                    </div>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-6">
                    <div class="text-sm font-medium text-gray-500">Total Products</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">
                        {{ stats.total_products }}
                    </div>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-6">
                    <div class="text-sm font-medium text-gray-500">Total Stock</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">
                        {{ stats.total_stock }}
                    </div>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-6">
                    <div class="text-sm font-medium text-gray-500">Total Orders</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">
                        {{ stats.total_orders }}
                    </div>
                </div>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-6">
                <h3 class="mb-4 text-lg font-semibold text-gray-900">Orders by Status</h3>
                <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                    <div>
                        <div class="text-sm text-gray-500">Pending</div>
                        <div class="mt-1 text-2xl font-bold text-gray-900">
                            {{ stats.orders_by_status.pending || 0 }}
                        </div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Confirmed</div>
                        <div class="mt-1 text-2xl font-bold text-gray-900">
                            {{ stats.orders_by_status.confirmed || 0 }}
                        </div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Delivered</div>
                        <div class="mt-1 text-2xl font-bold text-gray-900">
                            {{ stats.orders_by_status.delivered || 0 }}
                        </div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Cancelled</div>
                        <div class="mt-1 text-2xl font-bold text-gray-900">
                            {{ stats.orders_by_status.cancelled || 0 }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
