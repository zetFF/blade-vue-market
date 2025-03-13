<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import {
    ShoppingCartIcon,
    UserIcon,
    MagnifyingGlassIcon,
    Bars3Icon,
    XMarkIcon,
} from "@heroicons/vue/24/outline";

const isScrolled = ref(false);
const isMenuOpen = ref(false);
const isSearchOpen = ref(false);
const searchQuery = ref("");

const categories = [
    {
        name: "Food & Beverages",
        subcategories: ["Fresh Food", "Packaged Food", "Beverages", "Snacks"],
    },
    {
        name: "Organic Products",
        subcategories: ["Vegetables", "Fruits", "Dairy", "Meat"],
    },
    // Add more categories as needed
];

const form = useForm({});

const handleScroll = () => {
    isScrolled.value = window.scrollY > 30;
};

onMounted(() => {
    window.addEventListener("scroll", handleScroll);
});

onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
});

const toggleSearch = () => {
    isSearchOpen.value = !isSearchOpen.value;
    if (isSearchOpen.value) {
        setTimeout(() => {
            document.querySelector("#searchInput")?.focus();
        }, 100);
    }
};

const logout = () => {
    form.post(route("logout"));
};
</script>

<template>
    <div class="fixed w-full z-50">
        <!-- Top Bar - Hidden on Mobile -->
        <div class="hidden md:block bg-primary-600 text-white py-2 text-sm">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-6">
                        <a
                            href="tel:+123456789"
                            class="flex items-center hover:text-white/80 transition-colors"
                        >
                            <svg
                                class="w-4 h-4 mr-1"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                />
                            </svg>
                            <span>+123 456 7890</span>
                        </a>
                        <a
                            href="mailto:info@foodly.com"
                            class="flex items-center hover:text-white/80 transition-colors"
                        >
                            <svg
                                class="w-4 h-4 mr-1"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                />
                            </svg>
                            <span>info@foodly.com</span>
                        </a>
                    </div>
                    <div class="flex items-center space-x-6">
                        <Link
                            href="/track-order"
                            class="hover:text-white/80 transition-colors flex items-center"
                        >
                            Track Order
                        </Link>
                        <Link
                            href="/store-locator"
                            class="hover:text-white/80 transition-colors flex items-center"
                        >
                            Find a Store
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Navigation -->
        <nav
            :class="[
                'bg-white border-b border-gray-200 transition-all duration-300',
                isScrolled ? 'py-3 shadow-lg' : 'py-5',
            ]"
        >
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between">
                    <!-- Logo -->
                    <Link href="/" class="flex items-center space-x-3">
                        <img
                            src="https://res.cloudinary.com/ddy7p8yrj/image/upload/v1740853137/ek4zynulwomfupnlfhlt.png"
                            alt="Foodly"
                            class="h-10 w-auto"
                        />
                        <span class="text-2xl font-bold text-primary-600"
                            >Foodly</span
                        >
                    </Link>

                    <!-- Search Bar -->
                    <div class="hidden lg:block flex-1 max-w-2xl mx-8">
                        <div class="relative">
                            <input
                                type="text"
                                v-model="searchQuery"
                                placeholder="Search for products..."
                                class="w-full px-4 py-2.5 pl-12 rounded-full border border-gray-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all duration-300"
                            />
                            <MagnifyingGlassIcon
                                class="absolute left-4 top-3 h-5 w-5 text-gray-400"
                            />
                        </div>
                    </div>

                    <!-- Right Navigation -->
                    <div class="flex items-center space-x-6">
                        <!-- Categories Dropdown -->
                        <div class="hidden lg:block relative group">
                            <button
                                class="flex items-center space-x-1 text-gray-700 hover:text-primary-600 transition-colors"
                            >
                                <span>Categories</span>
                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 9l-7 7-7-7"
                                    />
                                </svg>
                            </button>
                            <!-- Dropdown Menu -->
                            <div
                                class="absolute top-full left-0 w-64 mt-2 bg-white rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50"
                            >
                                <div class="py-2">
                                    <Link
                                        v-for="category in categories"
                                        :key="category.name"
                                        :href="
                                            '/category/' +
                                            category.name
                                                .toLowerCase()
                                                .replace(/\s+/g, '-')
                                        "
                                        class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors"
                                    >
                                        {{ category.name }}
                                    </Link>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden lg:flex items-center space-x-6">
                            <Link
                                href="/deals"
                                class="text-gray-700 hover:text-primary-600 transition-colors"
                            >
                                Deals
                            </Link>
                            <Link
                                href="/whats-new"
                                class="text-gray-700 hover:text-primary-600 transition-colors"
                            >
                                What's New
                            </Link>
                        </div>

                        <!-- Auth Buttons or User Menu -->
                        <div class="flex items-center space-x-4">
                            <template v-if="$page.props.auth.user">
                                <!-- Cart Icon -->
                                <Link
                                    href="/cart"
                                    class="relative p-2 hover:bg-gray-100 rounded-full transition-colors"
                                >
                                    <ShoppingCartIcon
                                        class="h-6 w-6 text-gray-700"
                                    />
                                    <span
                                        class="absolute -top-1 -right-1 bg-primary-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"
                                        >3</span
                                    >
                                </Link>

                                <!-- User Dropdown -->
                                <div class="relative group">
                                    <button
                                        class="p-2 hover:bg-gray-100 rounded-full transition-colors"
                                    >
                                        <UserIcon
                                            class="h-6 w-6 text-gray-700"
                                        />
                                    </button>
                                    <div
                                        class="absolute right-0 w-48 mt-2 bg-white rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50"
                                    >
                                        <div class="py-2">
                                            <Link
                                                href="/profile"
                                                class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors"
                                            >
                                                My Profile
                                            </Link>
                                            <Link
                                                href="/orders"
                                                class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors"
                                            >
                                                My Orders
                                            </Link>
                                            <hr class="my-2" />
                                            <button
                                                @click="logout"
                                                class="w-full text-left px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors"
                                            >
                                                Logout
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <template v-else>
                                <!-- Login & Register Buttons -->
                                <Link
                                    href="/login"
                                    class="px-4 py-2 text-gray-700 hover:text-primary-600 transition-colors"
                                >
                                    Login
                                </Link>
                                <Link
                                    href="/register"
                                    class="px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors"
                                >
                                    Register
                                </Link>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Enhanced Mobile Menu -->
        <transition name="slide-fade">
            <div
                v-show="isMenuOpen"
                class="lg:hidden bg-white border-b border-gray-200 fixed top-[72px] left-0 right-0 h-[calc(100vh-72px)] overflow-y-auto z-50"
            >
                <div class="container mx-auto px-4 py-6">
                    <!-- Search Bar -->
                    <div class="relative mb-6">
                        <input
                            type="text"
                            v-model="searchQuery"
                            placeholder="Search for products..."
                            class="w-full px-4 py-2.5 pl-12 rounded-full border border-gray-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20"
                        />
                        <MagnifyingGlassIcon
                            class="absolute left-4 top-3 h-5 w-5 text-gray-400"
                        />
                    </div>

                    <!-- Contact Information Section -->
                    <div class="bg-gray-50 rounded-xl p-4 mb-6">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">
                            Contact Information
                        </h3>
                        <div class="space-y-3">
                            <a
                                href="tel:+123456789"
                                class="flex items-center text-gray-600 hover:text-primary-600 transition-colors"
                            >
                                <svg
                                    class="w-5 h-5 mr-3"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                    />
                                </svg>
                                +123 456 7890
                            </a>
                            <a
                                href="mailto:info@foodly.com"
                                class="flex items-center text-gray-600 hover:text-primary-600 transition-colors"
                            >
                                <svg
                                    class="w-5 h-5 mr-3"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                    />
                                </svg>
                                info@foodly.com
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links Section -->
                    <div class="bg-gray-50 rounded-xl p-4 mb-6">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">
                            Quick Links
                        </h3>
                        <div class="space-y-3">
                            <Link
                                href="/track-order"
                                class="flex items-center text-gray-600 hover:text-primary-600 transition-colors"
                            >
                                <svg
                                    class="w-5 h-5 mr-3"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                                    />
                                </svg>
                                Track Order
                            </Link>
                            <Link
                                href="/store-locator"
                                class="flex items-center text-gray-600 hover:text-primary-600 transition-colors"
                            >
                                <svg
                                    class="w-5 h-5 mr-3"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                    />
                                </svg>
                                Find a Store
                            </Link>
                        </div>
                    </div>

                    <!-- Categories Section -->
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">
                            Categories
                        </h3>
                        <div class="space-y-2">
                            <Link
                                v-for="category in categories"
                                :key="category.name"
                                :href="
                                    '/category/' +
                                    category.name
                                        .toLowerCase()
                                        .replace(/\s+/g, '-')
                                "
                                class="flex items-center px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition-colors"
                            >
                                <span class="mr-3">{{ category.icon }}</span>
                                {{ category.name }}
                            </Link>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <div class="space-y-2">
                        <Link
                            href="/deals"
                            class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition-colors"
                        >
                            Deals
                        </Link>
                        <Link
                            href="/whats-new"
                            class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition-colors"
                        >
                            What's New
                        </Link>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<style scoped>
.group:hover .group-hover\:block {
    display: block;
}

.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: all 0.3s ease;
}
.slide-fade-enter, .slide-fade-leave-to /* .slide-fade-leave-active in <2.1.8 */ {
    transform: translateY(-10px);
    opacity: 0;
}
</style>
