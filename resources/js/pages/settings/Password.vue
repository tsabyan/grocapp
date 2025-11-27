<script setup lang="ts">
import CustomerLayout from '@/layouts/CustomerLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft } from 'lucide-vue-next';

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put('/settings/password', {
        preserveScroll: true,
        resetOnSuccess: true,
        resetOnError: ['password', 'password_confirmation', 'current_password'],
    });
};
</script>

<template>
    <Head title="Change Password" />

    <CustomerLayout>
        <div class="mx-auto max-w-md px-4 py-6">
            <!-- Header -->
            <div class="mb-6 flex items-center gap-3">
                <Link
                    href="/dashboard"
                    class="flex items-center justify-center rounded-full p-2 text-gray-700 hover:bg-gray-100"
                >
                    <ArrowLeft class="h-5 w-5" />
                </Link>
                <h1 class="text-2xl font-bold text-gray-900">Change Password</h1>
            </div>

            <!-- Password Update Form -->
            <div class="rounded-lg border border-gray-200 bg-white p-4">
                <h2 class="mb-2 text-lg font-semibold text-gray-900">Update Password</h2>
                <p class="mb-4 text-sm text-gray-600">
                    Ensure your account is using a long, random password to stay secure.
                </p>

                <form @submit.prevent="updatePassword" class="space-y-4">
                    <div>
                        <label for="current_password" class="mb-1 block text-sm font-medium text-gray-700">
                            Current Password *
                        </label>
                        <input
                            id="current_password"
                            v-model="form.current_password"
                            type="password"
                            required
                            autocomplete="current-password"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900 focus:border-black focus:outline-none focus:ring-1 focus:ring-black"
                        />
                        <p v-if="form.errors.current_password" class="mt-1 text-sm text-red-600">
                            {{ form.errors.current_password }}
                        </p>
                    </div>

                    <div>
                        <label for="password" class="mb-1 block text-sm font-medium text-gray-700">
                            New Password *
                        </label>
                        <input
                            id="password"
                            v-model="form.password"
                            type="password"
                            required
                            autocomplete="new-password"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900 focus:border-black focus:outline-none focus:ring-1 focus:ring-black"
                        />
                        <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">
                            {{ form.errors.password }}
                        </p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="mb-1 block text-sm font-medium text-gray-700">
                            Confirm Password *
                        </label>
                        <input
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            type="password"
                            required
                            autocomplete="new-password"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900 focus:border-black focus:outline-none focus:ring-1 focus:ring-black"
                        />
                        <p v-if="form.errors.password_confirmation" class="mt-1 text-sm text-red-600">
                            {{ form.errors.password_confirmation }}
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="rounded-lg bg-black px-6 py-2 text-sm font-medium text-white hover:bg-gray-800 disabled:bg-gray-300"
                        >
                            {{ form.processing ? 'Saving...' : 'Save Password' }}
                        </button>
                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p
                                v-show="form.recentlySuccessful"
                                class="text-sm text-gray-600"
                            >
                                Saved.
                            </p>
                        </Transition>
                    </div>
                </form>
            </div>
        </div>
    </CustomerLayout>
</template>
