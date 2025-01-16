<template>
    <div class="bg-white">
        <Head title="Courses" />
        <HeaderSection />
        <main>
            <div class="min-h-screen flex flex-col justify-center items-center bg-gray-100">
                <img src="https://images.unsplash.com/photo-1499951360447-b19be8fe80f5" alt="Logo"
                    class="object-cover w-40 h-40 mb-8 rounded-full">
                <h1 class="text-4xl font-bold mb-4">Coming Soon</h1>
                <p class="text-lg mb-8 px-4 md:px-0">Something awesome would be on this page soon. Stay tuned!</p>
                <div class="flex justify-center items-center space-x-4">
                    <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Learn More</a>
                    <a href="#" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">Contact Us</a>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import HeaderSection from '@/Components/HeaderSection.vue'

</script>