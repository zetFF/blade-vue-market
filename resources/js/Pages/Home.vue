<script setup>
import { Head } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, onMounted, onUnmounted } from "vue";
import ReviewForm from "@/Components/ReviewForm.vue";
import {
    TruckIcon,
    ShieldCheckIcon,
    CurrencyDollarIcon,
    StarIcon,
    UsersIcon,
    PhoneIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
    initialSliders: {
        type: Array,
        default: () => [],
    },
    initialReviews: {
        type: Array,
        default: () => [],
    },
    initialCategories: {
        type: Array,
        default: () => [],
    },
    initialFeaturedProducts: {
        type: Array,
        default: () => [],
    },
});

const sliders = ref(props.initialSliders);
const reviews = ref(props.initialReviews);
const categories = ref(props.initialCategories);
const featuredProducts = ref(props.initialFeaturedProducts);
const currentSlide = ref(0);

const nextSlide = () => {
    currentSlide.value = (currentSlide.value + 1) % sliders.value.length;
};

const prevSlide = () => {
    currentSlide.value =
        currentSlide.value === 0
            ? sliders.value.length - 1
            : currentSlide.value - 1;
};

let slideInterval;
onMounted(() => {
    console.log("Featured Products:", featuredProducts.value);
    slideInterval = setInterval(nextSlide, 20000);
});

onUnmounted(() => {
    if (slideInterval) clearInterval(slideInterval);
});
</script>

<template>
    <Head title="Foodly - Your Premium Food Marketplace" />

    <AppLayout>
        <section class="section_hero relative w-full overflow-hidden">
            <!-- Hero Section with Slider -->
            <div v-if="sliders.length > 0" class="relative h-[90vh] min-h-[600px] md:min-h-[800px] w-full">
                <!-- Background Slider -->
                <div v-for="(slider, index) in sliders" 
                    :key="slider.id"
                    class="absolute inset-0 transition-all duration-1000"
                    :class="{
                        'opacity-100 scale-100': currentSlide === index,
                        'opacity-0 scale-110': currentSlide !== index
                    }"
                >
                    <!-- Background Image -->
                    <div class="relative h-full w-full">
                        <img
                            :src="'/storage/' + slider.image"
                            :alt="slider.title"
                            class="absolute inset-0 w-full h-full object-cover"
                        />
                        
                        <!-- Enhanced Overlay -->
                        <div class="absolute inset-0">
                            <div class="absolute inset-0 bg-gradient-to-r from-black/95 via-black/70 to-transparent"></div>
                            <div class="absolute inset-0 bg-[url('/pattern-dot.png')] opacity-20"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                        </div>

                        <!-- Main Content Container -->
                        <div class="relative h-full w-full">
                            <div class="container mx-auto px-4 sm:px-6 h-full">
                                <div class="grid grid-cols-1 lg:grid-cols-12 h-full items-center gap-8">
                                    <!-- Left Content -->
                                    <div class="col-span-1 lg:col-span-6 space-y-6 md:space-y-8 py-8 md:py-0">
                                        <!-- Badge & Title Section -->
                                        <div class="space-y-4 md:space-y-6" :class="{ 'animate-fade-in': currentSlide === index }">
                                            <div class="flex items-center space-x-4">
                                                <span class="px-3 py-1.5 md:px-4 md:py-2 bg-primary-500 text-white rounded-full text-xs md:text-sm font-medium 
                                                           shadow-lg shadow-primary-500/30 inline-flex items-center">
                                                    <svg class="w-3 h-3 md:w-4 md:h-4 mr-1.5 md:mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                    {{ slider.badge || 'Featured' }}
                                                </span>
                                            </div>

                                            <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white leading-tight tracking-tight">
                                                {{ slider.title }}
                                            </h1>

                                            <p class="text-base md:text-xl text-gray-300 leading-relaxed font-light max-w-2xl">
                                                {{ slider.description }}
                                            </p>
                                        </div>

                                        <!-- CTA Buttons -->
                                        <div class="flex flex-wrap items-center gap-4 md:gap-6" :class="{ 'animate-fade-in-delay': currentSlide === index }">
                                            <a v-if="slider.link"
                                               :href="slider.link"
                                               class="group relative inline-flex items-center px-6 py-3 md:px-8 md:py-4 bg-primary-500 text-white 
                                                      rounded-full overflow-hidden transition-all duration-300 text-sm md:text-base"
                                            >
                                                <span class="relative z-10 font-medium">Explore Now</span>
                                                <svg class="w-5 h-5 md:w-6 md:h-6 ml-2 relative z-10 group-hover:translate-x-1 transition-transform duration-300"
                                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                                </svg>
                                            </a>
                                            <a href="#"
                                               class="group inline-flex items-center px-6 py-3 md:px-8 md:py-4 border-2 border-white/30 text-white 
                                                      rounded-full transition-all duration-300 hover:bg-white hover:text-gray-900 text-sm md:text-base"
                                            >
                                                <span class="font-medium">Learn More</span>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Right Content - Feature Cards -->
                                    <div class="hidden lg:block lg:col-span-5 lg:col-start-8">
                                        <div class="grid gap-4 md:gap-6" :class="{ 'animate-fade-in-right': currentSlide === index }">
                                            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/10 transform hover:scale-105 transition-all duration-300">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="p-4 bg-primary-500/20 rounded-xl">
                                                            <svg class="w-8 h-8 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                                      d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="ml-6">
                                                        <h3 class="text-2xl font-bold text-white">Fast Delivery</h3>
                                                        <p class="text-gray-300 mt-2">Express delivery within 30 minutes</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/10 transform hover:scale-105 transition-all duration-300">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="p-4 bg-primary-500/20 rounded-xl">
                                                            <svg class="w-8 h-8 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="ml-6">
                                                        <h3 class="text-2xl font-bold text-white">Quality Assured</h3>
                                                        <p class="text-gray-300 mt-2">100% quality guarantee for all our products</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/10 transform hover:scale-105 transition-all duration-300">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="p-4 bg-primary-500/20 rounded-xl">
                                                            <svg class="w-8 h-8 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                                      d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="ml-6">
                                                        <h3 class="text-2xl font-bold text-white">Best Prices</h3>
                                                        <p class="text-gray-300 mt-2">Competitive prices with regular discounts</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Mobile Feature Cards -->
                                    <div class="lg:hidden col-span-1 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div class="bg-white/10 backdrop-blur-md rounded-xl p-4 border border-white/10">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="p-3 bg-primary-500/20 rounded-lg">
                                                        <svg class="w-6 h-6 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                                  d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <h3 class="text-lg font-semibold text-white">Fast Delivery</h3>
                                                    <p class="text-sm text-gray-300 mt-1">Express delivery within 30 minutes</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Slider Navigation - Responsive -->
                            <div class="absolute bottom-8 md:bottom-12 left-0 right-0 z-20">
                                <div class="container mx-auto px-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <!-- Slide Counter -->
                                        <div class="hidden md:block text-white font-medium">
                                            <span class="text-2xl">{{ currentSlide + 1 }}</span>
                                            <span class="text-gray-400">/{{ sliders.length }}</span>
                                        </div>

                                        <!-- Slide Controls -->
                                        <div class="flex items-center space-x-4 mx-auto md:mx-0">
                                            <button @click="prevSlide"
                                                    class="p-2 rounded-full border border-white/20 hover:bg-white/10 
                                                           transition-colors duration-300">
                                                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                                </svg>
                                            </button>
                                            <div class="flex space-x-2">
                                                <button v-for="(_, index) in sliders"
                                                        :key="index"
                                                        @click="currentSlide = index"
                                                        class="w-8 md:w-12 h-1 rounded-full transition-all duration-300"
                                                        :class="currentSlide === index ? 'bg-white' : 'bg-white/30 hover:bg-white/50'">
                                                </button>
                                            </div>
                                            <button @click="nextSlide"
                                                    class="p-2 rounded-full border border-white/20 hover:bg-white/10 
                                                           transition-colors duration-300">
                                                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Categories -->
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <h2 class="text-3xl font-bold mb-4 text-gray-900">
                        Explore Our Categories
                    </h2>
                    <p class="text-base text-gray-600">
                        Discover a world of delicious possibilities through our
                        carefully curated food categories
                    </p>
                </div>
                <div
                    class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4"
                >
                    <div
                        v-for="category in categories"
                        :key="category.id"
                        class="group relative overflow-hidden rounded-lg shadow-md transition-all duration-300 hover:-translate-y-1 hover:shadow-lg"
                    >
                        <img
                            :src="'/storage/' + category.image"
                            :alt="category.name"
                            class="w-full h-48 object-cover transition duration-300 group-hover:scale-105"
                        />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"
                        >
                            <div class="absolute bottom-0 left-0 p-4">
                                <h3
                                    class="text-lg font-semibold text-white mb-1"
                                >
                                    {{ category.name }}
                                </h3>
                                <p class="text-sm text-gray-200">
                                    {{ category.products_count }} Products
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Products -->
        <section class="py-12 featured_products">
            <div class="container mx-auto px-4">
                <div class="text-center max-w-3xl mx-auto mb-12">
                    <span
                        class="text-primary-500 font-semibold text-sm uppercase tracking-wider mb-2 block"
                        >Our Menu</span
                    >
                    <h2 class="text-3xl font-bold mb-4 text-gray-900">
                        Popular Dishes
                    </h2>
                    <p class="text-base text-gray-600">
                        Explore our most loved dishes, crafted with premium
                        ingredients and exceptional taste
                    </p>
                </div>

                <div
                    v-if="featuredProducts.length > 0"
                    class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4"
                >
                    <div
                        v-for="product in featuredProducts"
                        :key="product.id"
                        class="group bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden"
                    >
                        <!-- Image Container -->
                        <div class="relative overflow-hidden aspect-square">
                            <img
                                :src="
                                    product.image
                                        ? '/storage/' + product.image
                                        : '/images/placeholder-product.jpg'
                                "
                                :alt="product.name"
                                class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500"
                            />

                            <!-- Badges -->
                            <div
                                class="absolute top-2 left-2 flex flex-col gap-1"
                            >
                                <span
                                    class="bg-primary-500 text-white px-2 py-0.5 rounded-full text-xs font-medium"
                                >
                                    Featured
                                </span>
                                <span
                                    v-if="product.is_new"
                                    class="bg-green-500 text-white px-2 py-0.5 rounded-full text-xs font-medium"
                                >
                                    New
                                </span>
                            </div>

                            <!-- Quick Actions -->
                            <div
                                class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-2"
                            >
                                <button
                                    class="bg-white text-gray-900 p-2 rounded-full hover:bg-primary-500 hover:text-white transition-colors duration-300"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                        />
                                    </svg>
                                </button>
                                <button
                                    class="bg-white text-gray-900 p-2 rounded-full hover:bg-primary-500 hover:text-white transition-colors duration-300"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-3">
                            <div class="mb-2">
                                <h3
                                    class="text-sm font-bold text-gray-900 mb-1 truncate group-hover:text-primary-500 transition-colors duration-300"
                                >
                                    {{ product.name }}
                                </h3>
                                <p
                                    class="text-xs text-gray-600 line-clamp-2 h-8"
                                >
                                    {{ product.description }}
                                </p>
                            </div>

                            <div class="flex flex-col gap-2">
                                <div class="flex items-baseline gap-2">
                                    <span
                                        class="text-base font-bold text-primary-600"
                                    >
                                        Rp {{ product.price.toLocaleString() }}
                                    </span>
                                    <span
                                        v-if="product.original_price"
                                        class="text-xs text-gray-400 line-through"
                                    >
                                        Rp
                                        {{
                                            product.original_price.toLocaleString()
                                        }}
                                    </span>
                                </div>
                                <button
                                    class="w-full bg-primary-500 hover:bg-primary-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-300 hover:shadow-md hover:-translate-y-0.5"
                                >
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else class="text-center py-8">
                    <p class="text-gray-600">
                        No featured products available at the moment.
                    </p>
                </div>
            </div>
        </section>

        <!-- Why Choose Us -->
        <section class="py-20 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-4xl font-bold mb-6 text-gray-900">
                        Why Choose Foodly
                    </h2>
                    <p class="text-lg text-gray-600">
                        Experience the best food marketplace with our premium
                        services and commitment to quality
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div
                        v-for="item in whyChooseUs"
                        :key="item.id"
                        class="bg-white p-8 rounded-2xl shadow-lg text-center transition-transform duration-300 hover:-translate-y-2"
                    >
                        <div
                            class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-primary-100 text-primary-600 mb-6"
                        >
                            <component :is="item.icon" class="w-10 h-10" />
                        </div>
                        <h3 class="text-xl font-bold mb-4 text-gray-900">
                            {{ item.title }}
                        </h3>
                        <p class="text-gray-600">{{ item.description }}</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer -->
        <Footer />
    </AppLayout>
</template>

<style>
/* Custom Fonts */
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

/* Custom Styles */
.font-inter {
    font-family: "Inter", sans-serif;
}

/* Smooth Scrolling */
html {
    scroll-behavior: smooth;
}

/* Custom Animations */
.hover\:scale-up {
    transition: transform 0.3s ease;
}

.hover\:scale-up:hover {
    transform: scale(1.05);
}
</style>

<style scoped>
.animate-fade-in {
    animation: fadeIn 1s ease-out forwards;
}

.animate-fade-in-delay {
    animation: fadeIn 1s ease-out 0.3s forwards;
}

.animate-fade-in-right {
    animation: fadeInRight 1s ease-out forwards;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInRight {
    from {
        opacity: 0;
        transform: translateX(50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}
</style>
