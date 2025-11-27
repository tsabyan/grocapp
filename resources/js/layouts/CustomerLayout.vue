<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { Home, Grid3x3, ShoppingCart, User } from 'lucide-vue-next';
import { computed } from 'vue';

const page = usePage();
const cartCount = computed(() => (page.props.cartCount as number) || 0);
const appName = computed(() => (page.props.name as string) || 'GrocApp');
const currentUrl = computed(() => page.url);
const user = computed(() => page.props.auth?.user);

const isActive = (path: string) => {
    if (path === '/') {
        return currentUrl.value === '/';
    }
    return currentUrl.value.startsWith(path);
};
</script>

<template>
    <div class="flex min-h-screen flex-col bg-white">
        <!-- Top Bar -->
        <header class="sticky top-0 z-50 border-b border-gray-200 bg-white">
            <div class="mx-auto flex max-w-md items-center justify-between px-4 py-3">
                <Link href="/" class="text-lg font-bold text-gray-900">
                    {{ appName }}
                </Link>
                <Link
                    href="/cart"
                    data-cart-icon
                    class="relative flex items-center justify-center rounded-full p-2 text-gray-700 hover:bg-gray-100"
                >
                    <ShoppingCart class="h-6 w-6" />
                    <span
                        v-if="cartCount > 0"
                        class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-black text-xs font-medium text-white"
                    >
                        {{ cartCount }}
                    </span>
                </Link>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 pb-20">
            <slot />
        </main>

        <!-- Bottom Navigation Bar -->
        <nav class="fixed bottom-0 left-0 right-0 z-50 border-t border-gray-200 bg-white">
            <div class="mx-auto flex max-w-md items-center justify-around px-2 py-2">
                <!-- Home -->
                <Link
                    href="/"
                    :class="[
                        'flex flex-col items-center justify-center px-4 py-2 rounded-lg transition-colors',
                        isActive('/') ? 'text-black' : 'text-gray-500'
                    ]"
                >
                    <Home :class="['h-6 w-6', isActive('/') ? 'text-black' : 'text-gray-500']" />
                    <span class="mt-1 text-xs font-medium">Home</span>
                </Link>

                <!-- Categories -->
                <Link
                    href="/categories"
                    :class="[
                        'flex flex-col items-center justify-center px-4 py-2 rounded-lg transition-colors',
                        isActive('/categories') ? 'text-black' : 'text-gray-500'
                    ]"
                >
                    <Grid3x3 :class="['h-6 w-6', isActive('/categories') ? 'text-black' : 'text-gray-500']" />
                    <span class="mt-1 text-xs font-medium">Browse</span>
                </Link>

                <!-- Cart -->
                <Link
                    href="/cart"
                    data-cart-icon
                    :class="[
                        'relative flex flex-col items-center justify-center px-4 py-2 rounded-lg transition-colors',
                        isActive('/cart') ? 'text-black' : 'text-gray-500'
                    ]"
                >
                    <div class="relative">
                        <ShoppingCart :class="['h-6 w-6', isActive('/cart') ? 'text-black' : 'text-gray-500']" />
                        <span
                            v-if="cartCount > 0"
                            class="absolute -right-2 -top-2 flex h-5 w-5 items-center justify-center rounded-full bg-black text-xs font-medium text-white"
                        >
                            {{ cartCount > 9 ? '9+' : cartCount }}
                        </span>
                    </div>
                    <span class="mt-1 text-xs font-medium">Cart</span>
                </Link>

                <!-- Account -->
                <Link
                    :href="user ? '/dashboard' : '/login'"
                    :class="[
                        'flex flex-col items-center justify-center px-4 py-2 rounded-lg transition-colors',
                        isActive('/dashboard') || isActive('/login') ? 'text-black' : 'text-gray-500'
                    ]"
                >
                    <User :class="['h-6 w-6', (isActive('/dashboard') || isActive('/login')) ? 'text-black' : 'text-gray-500']" />
                    <span class="mt-1 text-xs font-medium">Account</span>
                </Link>
            </div>
        </nav>
    </div>
</template>
