<script setup lang="ts">
import CustomerLayout from '@/layouts/CustomerLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

interface Category {
    id: number;
    name: string;
    slug: string;
    products_count: number;
}

interface Props {
    categories: Category[];
}

defineProps<Props>();
</script>

<template>
    <Head title="Browse Categories" />

    <CustomerLayout>
        <div class="mx-auto max-w-md px-4 py-6">
            <h1 class="mb-6 text-2xl font-bold text-gray-900">Browse Categories</h1>

            <div v-if="categories.length === 0" class="py-12 text-center text-gray-600">
                <p>No categories available.</p>
            </div>

            <div v-else class="grid grid-cols-2 gap-4">
                <Link
                    v-for="category in categories"
                    :key="category.id"
                    :href="`/categories/${category.slug}`"
                    class="rounded-lg border border-gray-200 bg-white p-6 hover:shadow-md transition-shadow"
                >
                    <h3 class="mb-2 text-lg font-semibold text-gray-900">
                        {{ category.name }}
                    </h3>
                    <p class="text-sm text-gray-600">
                        {{ category.products_count }} {{ category.products_count === 1 ? 'product' : 'products' }}
                    </p>
                </Link>
            </div>
        </div>
    </CustomerLayout>
</template>
