<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { watch } from 'vue';

interface Category {
    id: number;
    name: string;
}

interface Product {
    id: number;
    name: string;
    stock: number;
    category: Category;
}

interface StockMovement {
    id: number;
    change: number;
    reason: string;
    created_at: string;
}

interface Props {
    products: Product[];
    selectedProduct: Product | null;
    stockMovements: StockMovement[];
}

const props = defineProps<Props>();

const stockForm = useForm({
    product_id: '',
    change: 0,
    reason: '',
});

// Update form when selectedProduct changes
watch(() => props.selectedProduct, (newProduct) => {
    if (newProduct) {
        stockForm.product_id = newProduct.id;
    }
}, { immediate: true });

const selectProduct = (productId: number) => {
    router.get('/admin/inventory', { product_id: productId }, { preserveState: true });
};

const submitStockChange = () => {
    stockForm.post('/admin/inventory/update', {
        preserveScroll: true,
        onSuccess: () => {
            stockForm.reset();
            stockForm.product_id = props.selectedProduct?.id || '';
        },
    });
};
</script>

<template>
    <Head title="Inventory" />

    <AdminLayout>
        <div class="space-y-6">
            <h2 class="text-2xl font-bold text-gray-900">Inventory Management</h2>

            <div class="rounded-lg border border-gray-200 bg-white p-6">
                <label for="product_select" class="block text-sm font-medium text-gray-700">
                    Select Product
                </label>
                <select
                    id="product_select"
                    :value="selectedProduct?.id || ''"
                    @change="selectProduct(Number(($event.target as HTMLSelectElement).value))"
                    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-500"
                >
                    <option value="">-- Select a product --</option>
                    <option
                        v-for="product in products"
                        :key="product.id"
                        :value="product.id"
                    >
                        {{ product.name }} ({{ product.category?.name || 'No Category' }})
                    </option>
                </select>
            </div>

            <div v-if="selectedProduct" class="space-y-6">
                <div class="rounded-lg border border-gray-200 bg-white p-6">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900">Current Stock</h3>
                    <div class="text-3xl font-bold text-gray-900">{{ selectedProduct.stock }}</div>
                    <div class="mt-2 text-sm text-gray-500">{{ selectedProduct.name }}</div>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-6">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900">Update Stock</h3>
                    <form @submit.prevent="submitStockChange" class="space-y-4">
                        <input type="hidden" v-model="stockForm.product_id" />
                        <div>
                            <label for="change" class="block text-sm font-medium text-gray-700">
                                Change <span class="text-red-500">*</span>
                                <span class="text-xs text-gray-500">(positive to add, negative to subtract)</span>
                            </label>
                            <input
                                id="change"
                                v-model.number="stockForm.change"
                                type="number"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-500"
                                required
                            />
                        </div>
                        <div>
                            <label for="reason" class="block text-sm font-medium text-gray-700">
                                Reason <span class="text-red-500">*</span>
                            </label>
                            <textarea
                                id="reason"
                                v-model="stockForm.reason"
                                rows="3"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-500"
                                required
                            />
                        </div>
                        <button
                            type="submit"
                            :disabled="stockForm.processing"
                            class="rounded-md border border-gray-900 bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800 disabled:opacity-50"
                        >
                            Update Stock
                        </button>
                    </form>
                </div>

                <div v-if="stockMovements.length > 0" class="rounded-lg border border-gray-200 bg-white p-6">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900">Recent Stock Movements</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                                    >
                                        Change
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                                    >
                                        Reason
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                                    >
                                        Date
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <tr v-for="movement in stockMovements" :key="movement.id">
                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-sm"
                                        :class="movement.change >= 0 ? 'text-green-600' : 'text-red-600'"
                                    >
                                        {{ movement.change >= 0 ? '+' : '' }}{{ movement.change }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ movement.reason }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                        {{ new Date(movement.created_at).toLocaleString() }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
