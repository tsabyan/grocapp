<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import InputError from '@/components/InputError.vue';

const form = useForm({
    name: '',
    slug: '',
    description: '',
});

const autoGenerateSlug = ref(true);

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
    form.post('/admin/categories', {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Create Category" />

    <AdminLayout>
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-900">Create Category</h2>
            </div>

            <form @submit.prevent="submit" class="space-y-6 rounded-lg border border-gray-200 bg-white p-6">
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

                <div class="flex gap-4">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="rounded-md border border-gray-900 bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800 disabled:opacity-50"
                    >
                        Create Category
                    </button>
                    <a
                        href="/admin/categories"
                        class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                    >
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
