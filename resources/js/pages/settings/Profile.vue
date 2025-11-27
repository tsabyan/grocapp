<script setup lang="ts">
import CustomerLayout from '@/layouts/CustomerLayout.vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import { ArrowLeft, Trash2 } from 'lucide-vue-next';
import { ref } from 'vue';

interface Props {
    mustVerifyEmail: boolean;
    status?: string;
}

const props = defineProps<Props>();

const page = usePage();
const user = page.props.auth?.user as { name: string; email: string; email_verified_at?: string | null };

const form = useForm({
    name: user.name,
    email: user.email,
});

const deleteForm = useForm({
    password: '',
});

const showDeleteModal = ref(false);
const showDeleteConfirm = ref(false);

const updateProfile = () => {
    form.patch('/settings/profile', {
        preserveScroll: true,
        onSuccess: () => {
            // Show success message briefly
        },
    });
};

const deleteAccount = () => {
    deleteForm.delete('/settings/profile', {
        preserveScroll: true,
        onSuccess: () => {
            router.visit('/');
        },
    });
};

const resendVerification = () => {
    router.post('/email/verification-notification', {}, {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Edit Profile" />

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
                <h1 class="text-2xl font-bold text-gray-900">Edit Profile</h1>
            </div>

            <!-- Profile Information Form -->
            <div class="mb-6 rounded-lg border border-gray-200 bg-white p-4">
                <h2 class="mb-4 text-lg font-semibold text-gray-900">Profile Information</h2>
                <p class="mb-4 text-sm text-gray-600">Update your name and email address.</p>

                <form @submit.prevent="updateProfile" class="space-y-4">
                    <div>
                        <label for="name" class="mb-1 block text-sm font-medium text-gray-700">
                            Name *
                        </label>
                        <input
                            id="name"
                            v-model="form.name"
                            type="text"
                            required
                            autocomplete="name"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900 focus:border-black focus:outline-none focus:ring-1 focus:ring-black"
                        />
                        <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">
                            {{ form.errors.name }}
                        </p>
                    </div>

                    <div>
                        <label for="email" class="mb-1 block text-sm font-medium text-gray-700">
                            Email Address *
                        </label>
                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            required
                            autocomplete="username"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900 focus:border-black focus:outline-none focus:ring-1 focus:ring-black"
                        />
                        <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">
                            {{ form.errors.email }}
                        </p>
                    </div>

                    <!-- Email Verification Notice -->
                    <div v-if="mustVerifyEmail && !user.email_verified_at" class="rounded-lg border border-yellow-200 bg-yellow-50 p-3">
                        <p class="text-sm text-yellow-800">
                            Your email address is unverified.
                            <button
                                type="button"
                                @click="resendVerification"
                                class="font-medium underline hover:text-yellow-900"
                            >
                                Click here to resend the verification email.
                            </button>
                        </p>
                        <div
                            v-if="status === 'verification-link-sent'"
                            class="mt-2 text-sm font-medium text-green-600"
                        >
                            A new verification link has been sent to your email address.
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="rounded-lg bg-black px-6 py-2 text-sm font-medium text-white hover:bg-gray-800 disabled:bg-gray-300"
                        >
                            {{ form.processing ? 'Saving...' : 'Save' }}
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

            <!-- Delete Account Section -->
            <div class="rounded-lg border border-red-200 bg-red-50 p-4">
                <h2 class="mb-2 text-lg font-semibold text-gray-900">Delete Account</h2>
                <p class="mb-4 text-sm text-gray-600">Delete your account and all of its resources.</p>

                <div class="mb-4 rounded-lg border border-red-300 bg-red-100 p-3">
                    <p class="text-sm font-medium text-red-800">
                        Warning: Please proceed with caution, this cannot be undone.
                    </p>
                </div>

                <!-- Delete Confirmation Modal -->
                <div
                    v-if="showDeleteConfirm"
                    class="fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-50 p-4"
                    @click.self="showDeleteConfirm = false; deleteForm.reset()"
                >
                    <div class="w-full max-w-md rounded-lg bg-white p-6">
                        <h3 class="mb-2 text-lg font-semibold text-gray-900">Delete Account</h3>
                        <p class="mb-4 text-sm text-gray-600">
                            Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm.
                        </p>

                        <form @submit.prevent="deleteAccount" class="space-y-4">
                            <div>
                                <label for="delete_password" class="mb-1 block text-sm font-medium text-gray-700">
                                    Password *
                                </label>
                                <input
                                    id="delete_password"
                                    v-model="deleteForm.password"
                                    type="password"
                                    required
                                    autocomplete="current-password"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900 focus:border-black focus:outline-none focus:ring-1 focus:ring-black"
                                />
                                <p v-if="deleteForm.errors.password" class="mt-1 text-sm text-red-600">
                                    {{ deleteForm.errors.password }}
                                </p>
                            </div>

                            <div class="flex gap-3">
                                <button
                                    type="button"
                                    @click="showDeleteConfirm = false; deleteForm.reset()"
                                    class="flex-1 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                                >
                                    Cancel
                                </button>
                                <button
                                    type="submit"
                                    :disabled="deleteForm.processing"
                                    class="flex-1 rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 disabled:bg-gray-300"
                                >
                                    {{ deleteForm.processing ? 'Deleting...' : 'Delete Account' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <button
                    type="button"
                    @click="showDeleteConfirm = true"
                    class="flex w-full items-center justify-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700"
                >
                    <Trash2 class="h-4 w-4" />
                    <span>Delete Account</span>
                </button>
            </div>
        </div>
    </CustomerLayout>
</template>
