<script setup lang="ts">
import CustomerLayout from '@/layouts/CustomerLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed, onMounted, onUnmounted, watch } from 'vue';
import { Search, Loader2 } from 'lucide-vue-next';

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

interface PaginatedProducts {
    data: Product[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    next_page_url: string | null;
}

interface Props {
    categories: Category[];
    featuredProducts: PaginatedProducts;
    searchQuery?: string;
}

const props = defineProps<Props>();

const searchInput = ref(props.searchQuery || '');
const products = ref<Product[]>([...props.featuredProducts.data]);
const currentPage = ref(props.featuredProducts.current_page);
const lastPage = ref(props.featuredProducts.last_page);
const isLoading = ref(false);
const loadMoreTrigger = ref<HTMLElement | null>(null);
let observer: IntersectionObserver | null = null;

const hasMore = computed(() => currentPage.value < lastPage.value);

const performSearch = () => {
    // Reset products when searching
    products.value = [];
    currentPage.value = 1;

    if (searchInput.value.trim()) {
        router.get('/', { search: searchInput.value.trim() }, {
            preserveState: false,
            preserveScroll: false,
            onSuccess: (page) => {
                const newProducts = (page.props.featuredProducts as PaginatedProducts);
                products.value = [...newProducts.data];
                currentPage.value = newProducts.current_page;
                lastPage.value = newProducts.last_page;
            },
        });
    } else {
        router.get('/', {}, {
            preserveState: false,
            preserveScroll: false,
            onSuccess: (page) => {
                const newProducts = (page.props.featuredProducts as PaginatedProducts);
                products.value = [...newProducts.data];
                currentPage.value = newProducts.current_page;
                lastPage.value = newProducts.last_page;
            },
        });
    }
};

const handleSearchSubmit = (e: Event) => {
    e.preventDefault();
    performSearch();
};

const clearSearch = () => {
    searchInput.value = '';
    products.value = [];
    currentPage.value = 1;
    router.get('/', {}, {
        preserveState: false,
        preserveScroll: false,
        onSuccess: (page) => {
            const newProducts = (page.props.featuredProducts as PaginatedProducts);
            products.value = [...newProducts.data];
            currentPage.value = newProducts.current_page;
            lastPage.value = newProducts.last_page;
        },
    });
};

const loadMore = () => {
    if (isLoading.value || !hasMore.value) return;

    isLoading.value = true;
    const nextPage = currentPage.value + 1;
    const params: Record<string, any> = { page: nextPage };

    if (searchInput.value.trim()) {
        params.search = searchInput.value.trim();
    }

    router.get('/', params, {
        preserveState: true,
        preserveScroll: true,
        only: ['featuredProducts'],
        onSuccess: (page) => {
            const newProducts = (page.props.featuredProducts as PaginatedProducts);
            products.value = [...products.value, ...newProducts.data];
            currentPage.value = newProducts.current_page;
            lastPage.value = newProducts.last_page;
            isLoading.value = false;
        },
        onError: () => {
            isLoading.value = false;
        },
    });
};

const setupIntersectionObserver = () => {
    if (observer) {
        observer.disconnect();
    }

    if (!loadMoreTrigger.value || !hasMore.value) return;

    observer = new IntersectionObserver(
        (entries) => {
            const entry = entries[0];
            if (entry.isIntersecting && hasMore.value && !isLoading.value) {
                loadMore();
            }
        },
        {
            rootMargin: '100px', // Start loading 100px before reaching the bottom
        }
    );

    observer.observe(loadMoreTrigger.value);
};

onMounted(() => {
    // Setup observer after component is mounted
    setTimeout(() => {
        setupIntersectionObserver();
    }, 100);
});

onUnmounted(() => {
    if (observer) {
        observer.disconnect();
    }
});

// Watch for changes in hasMore to setup/teardown observer
watch(hasMore, (newVal) => {
    if (newVal) {
        setTimeout(() => {
            setupIntersectionObserver();
        }, 100);
    } else if (observer) {
        observer.disconnect();
    }
});

// Watch for prop changes (when search changes from outside)
watch(() => props.featuredProducts, (newProducts) => {
    if (currentPage.value === 1) {
        products.value = [...newProducts.data];
        currentPage.value = newProducts.current_page;
        lastPage.value = newProducts.last_page;
    }
}, { deep: true });
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
                    {{ props.searchQuery ? `Search Results${products.length > 0 ? ` (${props.featuredProducts.total})` : ''}` : 'Featured Products' }}
                </h2>
                <div v-if="products.length === 0 && props.searchQuery" class="py-8 text-center text-gray-600">
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
                        v-for="product in products"
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

                <!-- Loading indicator and infinite scroll trigger -->
                <div v-if="hasMore" ref="loadMoreTrigger" class="mt-6 flex justify-center py-4">
                    <div v-if="isLoading" class="flex items-center gap-2 text-gray-600">
                        <Loader2 class="h-5 w-5 animate-spin" />
                        <span class="text-sm">Loading more products...</span>
                    </div>
                    <div v-else class="h-20"></div>
                </div>

                <div v-if="!hasMore && products.length > 0" class="mt-6 py-4 text-center text-sm text-gray-600">
                    <p>No more products to load</p>
                </div>
            </div>
        </div>
    </CustomerLayout>
</template>
