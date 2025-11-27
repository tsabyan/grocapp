<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import InputError from '@/components/InputError.vue';

interface Category {
    id: number;
    name: string;
}

interface Product {
    id: number;
    category_id: number;
    name: string;
    slug: string;
    description: string | null;
    price: string;
    unit: string;
    stock: number;
    image_url: string | null;
    is_active: boolean;
    category: Category;
}

interface Props {
    product: Product;
    categories: Category[];
}

const props = defineProps<Props>();

const form = useForm({
    category_id: props.product.category_id,
    name: props.product.name,
    slug: props.product.slug,
    description: props.product.description || '',
    price: props.product.price,
    unit: props.product.unit,
    stock: props.product.stock,
    image_url: props.product.image_url || '',
    is_active: props.product.is_active,
});

const autoGenerateSlug = ref(false);

watch(
    () => form.name,
    (newName) => {
        if (autoGenerateSlug.value && newName) {
            form.slug = newName
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/(^-|-$)/g, '');
        }
    },
);

const submit = () => {
    form.put(`/admin/products/${props.product.id}`, {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Edit Product" />

    <AdminLayout>
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-900">Edit Product</h2>
            </div>

            <form @submit.prevent="submit" class="space-y-6 rounded-lg border border-gray-200 bg-white p-6">
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="category_id"
                        v-model="form.category_id"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-500"
                        required
                    >
                        <option value="">Select a category</option>
                        <option
                            v-for="category in categories"
                            :key="category.id"
                            :value="category.id"
                        >
                            {{ category.name }}
                        </option>
                    </select>
                    <InputError :message="form.errors.category_id" />
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="name"
                        v-model="form.name"
                        type="text"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-500"
                        required
                    />
                    <InputError :message="form.errors.name" />
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700">
                        Slug <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1 flex items-center gap-2">
                        <input
                            id="slug"
                            v-model="form.slug"
                            type="text"
                            class="block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-500"
                            required
                        />
                        <label class="flex items-center gap-2 text-sm text-gray-600">
                            <input
                                v-model="autoGenerateSlug"
                                type="checkbox"
                                class="rounded border-gray-300"
                            />
                            Auto-generate
                        </label>
                    </div>
                    <InputError :message="form.errors.slug" />
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">
                        Description
                    </label>
                    <textarea
                        id="description"
                        v-model="form.description"
                        rows="4"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-500"
                    />
                    <InputError :message="form.errors.description" />
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">
                            Price <span class="text-red-500">*</span>
                        </label>
                        <input
                            id="price"
                            v-model="form.price"
                            type="number"
                            step="0.01"
                            min="0"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-500"
                            required
                        />
                        <InputError :message="form.errors.price" />
                    </div>

                    <div>
                        <label for="unit" class="block text-sm font-medium text-gray-700">
                            Unit <span class="text-red-500">*</span>
                        </label>
                        <input
                            id="unit"
                            v-model="form.unit"
                            type="text"
                            placeholder="kg, pack, pcs, etc."
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-500"
                            required
                        />
                        <InputError :message="form.errors.unit" />
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700">
                            Stock <span class="text-red-500">*</span>
                        </label>
                        <input
                            id="stock"
                            v-model="form.stock"
                            type="number"
                            min="0"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-500"
                            required
                        />
                        <InputError :message="form.errors.stock" />
                    </div>

                    <div>
                        <label for="image_url" class="block text-sm font-medium text-gray-700">
                            Image URL
                        </label>
                        <input
                            id="image_url"
                            v-model="form.image_url"
                            type="url"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-500"
                        />
                        <InputError :message="form.errors.image_url" />
                    </div>
                </div>

                <div>
                    <label class="flex items-center gap-2">
                        <input
                            v-model="form.is_active"
                            type="checkbox"
                            class="rounded border-gray-300"
                        />
                        <span class="text-sm font-medium text-gray-700">Active</span>
                    </label>
                    <InputError :message="form.errors.is_active" />
                </div>

                <div class="flex gap-4">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="rounded-md border border-gray-900 bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800 disabled:opacity-50"
                    >
                        Update Product
                    </button>
                    <a
                        href="/admin/products"
                        class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                    >
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
