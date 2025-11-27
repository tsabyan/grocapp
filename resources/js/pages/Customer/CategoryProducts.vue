<script setup lang="ts">
import CustomerLayout from '@/layouts/CustomerLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useCartAnimation } from '@/composables/useCartAnimation';

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
    stock: number;
}

interface Props {
    category: Category;
    products: {
        data: Product[];
        links: any[];
        current_page: number;
        last_page: number;
    };
}

const props = defineProps<Props>();
const addingProductId = ref<number | null>(null);
const productImageRefs = ref<Record<number, HTMLElement | null>>({});
const { animateToCart } = useCartAnimation();

const addToCart = async (productId: number, imageUrl: string | null) => {
    addingProductId.value = productId;

    // Trigger animation before API call
    const imageElement = productImageRefs.value[productId];
    if (imageElement) {
        animateToCart(imageElement, imageUrl);
    }

    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const response = await fetch('/cart/add', {
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
                quantity: 1,
            }),
        });

        const data = await response.json();

        if (response.ok && data.success) {
            // Small delay to ensure animation completes, then reload shared props
            setTimeout(() => {
                router.reload({
                    only: [],
                    preserveScroll: true,
                });
            }, 100);
        } else {
            alert(data.error || 'Failed to add item to cart');
        }
    } catch (error) {
        console.error('Error adding to cart:', error);
        alert('Failed to add item to cart');
    } finally {
        addingProductId.value = null;
    }
};
</script>

<template>
    <Head :title="category.name" />

    <CustomerLayout>
        <div class="mx-auto max-w-md px-4 py-6">
            <h1 class="mb-6 text-2xl font-bold text-gray-900">{{ category.name }}</h1>

            <div class="grid grid-cols-2 gap-4">
                <div
                    v-for="product in products.data"
                    :key="product.id"
                    class="rounded-lg border border-gray-200 bg-white p-3"
                >
                    <Link :href="`/products/${product.slug}`">
                        <div
                            v-if="product.image_url"
                            :ref="el => productImageRefs[product.id] = el as HTMLElement"
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
                            :ref="el => productImageRefs[product.id] = el as HTMLElement"
                            class="mb-2 aspect-square w-full rounded-lg bg-gray-100"
                        />
                        <h3 class="mb-1 text-sm font-medium text-gray-900 line-clamp-2">
                            {{ product.name }}
                        </h3>
                        <p class="mb-2 text-sm font-semibold text-gray-900">
                            ${{ Number(product.price).toFixed(2) }} / {{ product.unit }}
                        </p>
                    </Link>
                    <button
                        @click="addToCart(product.id, product.image_url)"
                        :disabled="product.stock === 0 || addingProductId === product.id"
                        class="w-full rounded-lg bg-black px-3 py-2 text-sm font-medium text-white hover:bg-gray-800 disabled:bg-gray-300 disabled:cursor-not-allowed"
                    >
                        {{ addingProductId === product.id ? 'Adding...' : product.stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                    </button>
                </div>
            </div>

            <!-- Pagination -->
            <div v-if="products.last_page > 1" class="mt-6 flex justify-center gap-2">
                <button
                    v-if="products.current_page > 1"
                    @click="router.get(`/categories/${category.slug}?page=${products.current_page - 1}`)"
                    class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                >
                    Previous
                </button>
                <span class="px-4 py-2 text-sm text-gray-600">
                    Page {{ products.current_page }} of {{ products.last_page }}
                </span>
                <button
                    v-if="products.current_page < products.last_page"
                    @click="router.get(`/categories/${category.slug}?page=${products.current_page + 1}`)"
                    class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                >
                    Next
                </button>
            </div>
        </div>
    </CustomerLayout>
</template>
