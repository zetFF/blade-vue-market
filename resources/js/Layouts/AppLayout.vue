<script setup>
import { Link } from "@inertiajs/vue3";
import Footer from "@/Components/Footer.vue";
import Navbar from "@/Components/Navbar.vue";
</script>

<template>
    <div>
        <Navbar />

        <!-- Main Content -->
        <main>
            <slot />
        </main>

        <Footer />
    </div>
</template>
