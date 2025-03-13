<script setup>
import { defineProps } from 'vue'

const props = defineProps({
    product: {
        type: Object,
        required: true
    }
})
</script>

<template>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <img 
            :src="product.image" 
            :alt="product.name"
            class="w-full h-48 object-cover"
        >
        <div class="p-6">
            <h3 class="font-semibold mb-2">{{ product.name }}</h3>
            <p class="text-gray-600 mb-4">{{ product.description }}</p>
            <div class="flex justify-between items-center">
                <span class="text-xl font-bold">
                    Rp {{ product.price.toLocaleString() }}
                </span>
                <button 
                    @click="$emit('add-to-cart', product)"
                    class="bg-primary-600 text-white px-4 py-2 rounded"
                >
                    Add to Cart
                </button>
            </div>
        </div>
    </div>
</template> 