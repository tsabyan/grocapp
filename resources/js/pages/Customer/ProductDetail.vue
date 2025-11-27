<script setup lang="ts">
import CustomerLayout from '@/layouts/CustomerLayout.vue';
import { Head, router } from '@inertiajs/vue3';
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
    description: string | null;
    image_url: string | null;
    stock: number;
    category: Category;
}

interface Props {
    product: Product;
}

const props = defineProps<Props>();

const quantity = ref(1);
const isAdding = ref(false);
const productImageRef = ref<HTMLElement | null>(null);
const { animateToCart } = useCartAnimation();

const addToCart = async () => {
    if (quantity.value < 1 || quantity.value > props.product.stock) {
        return;
    }

    isAdding.value = true;

    // Trigger animation before API call
    if (productImageRef.value) {
        animateToCart(productImageRef.value, props.product.image_url);
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
                product_id: props.product.id,
                quantity: quantity.value,
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
        isAdding.value = false;
    }
};

const incrementQuantity = () => {
    if (quantity.value < props.product.stock) {
        quantity.value++;
    }
};

const decrementQuantity = () => {
    if (quantity.value > 1) {
        quantity.value--;
    }
};
</script>

<template>
    <Head :title="product.name" />

    <CustomerLayout>
        <div class="mx-auto max-w-md px-4 py-6">
            <!-- Product Image -->
            <div
                v-if="product.image_url"
                ref="productImageRef"
                class="mb-6 aspect-square w-full overflow-hidden rounded-lg bg-gray-100"
            >
                <img
                    :src="product.image_url"
                    :alt="product.name"
                    class="h-full w-full object-cover"
                />
            </div>
            <div
                v-else
                ref="productImageRef"
                class="mb-6 aspect-square w-full rounded-lg bg-gray-100"
            />

            <!-- Product Info -->
            <h1 class="mb-2 text-2xl font-bold text-gray-900">{{ product.name }}</h1>
            <p class="mb-4 text-lg font-semibold text-gray-900">
                ${{ Number(product.price).toFixed(2) }} / {{ product.unit }}
            </p>

            <!-- Stock Status -->
            <div class="mb-4">
                <span
                    :class="product.stock > 0 ? 'text-green-600' : 'text-red-600'"
                    class="text-sm font-medium"
                >
                    {{ product.stock > 0 ? `In Stock (${product.stock} available)` : 'Out of Stock' }}
                </span>
            </div>

            <!-- Description -->
            <div v-if="product.description" class="mb-6">
                <h2 class="mb-2 text-lg font-semibold text-gray-900">Description</h2>
                <p class="text-gray-600">{{ product.description }}</p>
            </div>

            <!-- Quantity Selector -->
            <div class="mb-6">
                <label class="mb-2 block text-sm font-medium text-gray-700">Quantity</label>
                <div class="flex items-center gap-4">
                    <button
                        @click="decrementQuantity"
                        :disabled="quantity <= 1"
                        class="flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 disabled:bg-gray-100 disabled:text-gray-400"
                    >
                        −
                    </button>
                    <span class="text-lg font-semibold text-gray-900">{{ quantity }}</span>
                    <button
                        @click="incrementQuantity"
                        :disabled="quantity >= product.stock"
                        class="flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 disabled:bg-gray-100 disabled:text-gray-400"
                    >
                        +
                    </button>
                </div>
            </div>

            <!-- Add to Cart Button -->
            <button
                @click="addToCart"
                :disabled="product.stock === 0 || isAdding"
                class="w-full rounded-lg bg-black px-6 py-3 text-base font-medium text-white hover:bg-gray-800 disabled:bg-gray-300 disabled:cursor-not-allowed"
            >
                {{ isAdding ? 'Adding...' : product.stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
            </button>
        </div>
    </CustomerLayout>
</template>
