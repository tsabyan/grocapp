<script setup lang="ts">
import CustomerLayout from '@/layouts/CustomerLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Search } from 'lucide-vue-next';

interface Category {
    id: number;
    name: string;
    slug: string;
}

interface Product {
    id: number;
    name: string;
    slug: string;
    price: number;
    unit: string;
    image_url: string | null;
    category: Category;
}

interface Props {
    categories: Category[];
    featuredProducts: Product[];
    searchQuery?: string;
}

const props = defineProps<Props>();

const searchInput = ref(props.searchQuery || '');

const performSearch = () => {
    if (searchInput.value.trim()) {
        router.get('/', { search: searchInput.value.trim() }, {
            preserveState: true,
            preserveScroll: true,
        });
    } else {
        router.get('/', {}, {
            preserveState: true,
            preserveScroll: true,
        });
    }
};

const handleSearchSubmit = (e: Event) => {
    e.preventDefault();
    performSearch();
};

const clearSearch = () => {
    searchInput.value = '';
    router.get('/', {}, {
        preserveState: true,
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Home" />

    <CustomerLayout>
        <div class="mx-auto max-w-md px-4 py-6">
            <!-- Hero Section -->
            <div class="mb-6 text-center">
                <h1 class="mb-2 text-2xl font-bold text-gray-900">Welcome to GrocApp</h1>
                <p class="text-gray-600">Fresh groceries delivered to your door</p>
            </div>

            <!-- Search Bar -->
            <div class="mb-6">
                <form @submit="handleSearchSubmit" class="relative">
                    <div class="flex items-center rounded-lg border border-gray-300 bg-white px-4 py-3">
                        <Search class="mr-2 h-5 w-5 flex-shrink-0 text-gray-400" />
                        <input
                            v-model="searchInput"
                            type="text"
                            placeholder="Search products..."
                            class="flex-1 border-none bg-transparent text-gray-900 placeholder-gray-400 focus:outline-none"
                        />
                        <button
                            v-if="searchInput"
                            @click="clearSearch"
                            type="button"
                            class="ml-2 text-gray-400 hover:text-gray-600"
                        >
                            ✕
                        </button>
                    </div>
                </form>
            </div>

            <!-- Categories -->
            <div class="mb-8">
                <h2 class="mb-3 text-lg font-semibold text-gray-900">Categories</h2>
                <div class="flex gap-3 overflow-x-auto pb-2">
                    <Link
                        v-for="category in categories"
                        :key="category.id"
                        :href="`/categories/${category.slug}`"
                        class="flex-shrink-0 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors"
                    >
                        {{ category.name }}
                    </Link>
                </div>
            </div>

            <!-- Featured Products / Search Results -->
            <div>
                <h2 class="mb-3 text-lg font-semibold text-gray-900">
                    {{ props.searchQuery ? `Search Results${featuredProducts.length > 0 ? ` (${featuredProducts.length})` : ''}` : 'Featured Products' }}
                </h2>
                <div v-if="featuredProducts.length === 0 && props.searchQuery" class="py-8 text-center text-gray-600">
                    <p>No products found for "{{ props.searchQuery }}".</p>
                    <button
                        @click="clearSearch"
                        class="mt-4 text-sm text-gray-900 underline hover:text-gray-700"
                    >
                        Clear search
                    </button>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <Link
                        v-for="product in featuredProducts"
                        :key="product.id"
                        :href="`/products/${product.slug}`"
                        class="rounded-lg border border-gray-200 bg-white p-3 hover:shadow-md transition-shadow cursor-pointer"
                    >
                        <div
                            v-if="product.image_url"
                            class="mb-2 aspect-square w-full overflow-hidden rounded-lg bg-gray-100"
                        >
                            <img
                                :src="product.image_url"
                                :alt="product.name"
                                class="h-full w-full object-cover"
                            />
                        </div>
                        <div
                            v-else
                            class="mb-2 aspect-square w-full rounded-lg bg-gray-100"
                        />
                        <h3 class="mb-1 text-sm font-medium text-gray-900 line-clamp-2">
                            {{ product.name }}
                        </h3>
                        <p class="text-sm font-semibold text-gray-900">
                            ${{ product.price ? Number(product.price).toFixed(2) : '0.00' }} / {{ product.unit || '' }}
                        </p>
                    </Link>
                </div>
            </div>
        </div>
    </CustomerLayout>
</template>
