<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    name: "",
    email: "",
    rating: 5,
    comment: "",
});

const isSuccess = ref(false);
const isError = ref(false);

const submitReview = () => {
    form.post("/reviews", {
        onSuccess: () => {
            isSuccess.value = true;
            form.reset();
            setTimeout(() => {
                isSuccess.value = false;
            }, 3000);
        },
        onError: () => {
            isError.value = true;
            setTimeout(() => {
                isError.value = false;
            }, 3000);
        },
    });
};
</script>

<template>
    <div
        class="max-w-3xl mx-auto bg-white p-10 rounded-3xl shadow-xl border border-gray-100"
    >
        <h3 class="text-4xl font-bold mb-8 text-gray-900 text-center">
            Share Your Experience
        </h3>

        <!-- Success Message -->
        <div
            v-if="isSuccess"
            class="mb-8 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl animate-fade-in"
        >
            <div class="flex items-center justify-center">
                <svg
                    class="w-6 h-6 mr-3"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                >
                    <path
                        fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"
                    />
                </svg>
                <span class="font-medium"
                    >Thank you for sharing your experience!</span
                >
            </div>
        </div>

        <!-- Error Message -->
        <div
            v-if="isError"
            class="mb-8 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl animate-fade-in"
        >
            <div class="flex items-center justify-center">
                <svg
                    class="w-6 h-6 mr-3"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                >
                    <path
                        fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd"
                    />
                </svg>
                <span class="font-medium"
                    >There was an error submitting your review. Please try
                    again.</span
                >
            </div>
        </div>

        <form @submit.prevent="submitReview" class="space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">
                        Name
                    </label>
                    <input
                        v-model="form.name"
                        type="text"
                        class="w-full px-5 py-4 text-gray-700 bg-gray-50 border-0 rounded-xl focus:ring-2 focus:ring-primary-500 transition duration-200"
                        placeholder="Enter your name"
                        required
                    />
                    <div
                        v-if="form.errors.name"
                        class="text-red-500 text-sm mt-2 font-medium"
                    >
                        {{ form.errors.name }}
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">
                        Email
                    </label>
                    <input
                        v-model="form.email"
                        type="email"
                        class="w-full px-5 py-4 text-gray-700 bg-gray-50 border-0 rounded-xl focus:ring-2 focus:ring-primary-500 transition duration-200"
                        placeholder="Enter your email"
                        required
                    />
                    <div
                        v-if="form.errors.email"
                        class="text-red-500 text-sm mt-2 font-medium"
                    >
                        {{ form.errors.email }}
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">
                        Rating
                    </label>
                    <select
                        v-model="form.rating"
                        class="w-full px-5 py-4 text-gray-700 bg-gray-50 border-0 rounded-xl focus:ring-2 focus:ring-primary-500 transition duration-200 appearance-none cursor-pointer"
                    >
                        <option v-for="n in 5" :key="n" :value="n">
                            {{ n }} {{ n === 1 ? "Star" : "Stars" }}
                        </option>
                    </select>
                    <div
                        v-if="form.errors.rating"
                        class="text-red-500 text-sm mt-2 font-medium"
                    >
                        {{ form.errors.rating }}
                    </div>
                </div>

                <div class="md:col-span-2 space-y-2">
                    <label class="text-sm font-semibold text-gray-700">
                        Comment
                    </label>
                    <textarea
                        v-model="form.comment"
                        rows="4"
                        class="w-full px-5 py-4 text-gray-700 bg-gray-50 border-0 rounded-xl focus:ring-2 focus:ring-primary-500 transition duration-200 resize-none"
                        placeholder="Share your experience..."
                        required
                    ></textarea>
                    <div
                        v-if="form.errors.comment"
                        class="text-red-500 text-sm mt-2 font-medium"
                    >
                        {{ form.errors.comment }}
                    </div>
                </div>

                <div class="md:col-span-2">
                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-primary-500 to-primary-600 text-white py-4 px-8 rounded-xl hover:from-primary-600 hover:to-primary-700 transition-all duration-300 font-bold text-lg shadow-lg hover:shadow-xl disabled:opacity-70 disabled:cursor-not-allowed"
                        :disabled="form.processing"
                    >
                        <span
                            v-if="form.processing"
                            class="flex items-center justify-center"
                        >
                            <svg
                                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <circle
                                    class="opacity-25"
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="4"
                                ></circle>
                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                ></path>
                            </svg>
                            Submitting...
                        </span>
                        <span v-else>Submit Review</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>
