<script setup>
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    lesson: Object,
})


</script>


<template>
    <Head title="Lesson" />
    <h1>Test</h1>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- <h2 class="text-2xl font-semibold">{{ lesson.title }}</h2>
        <div class="my-8 prose max-w-none" v-html="lesson.content">

        </div> -->
    </div>
</template>
