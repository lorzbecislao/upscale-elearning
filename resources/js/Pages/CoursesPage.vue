<template>
    <div class="bg-white">
        <Head title="Courses" />
        <HeaderSection />
        <main>
            <div class="mx-auto mt-32 max-w-7xl px-6 sm:mt-56 lg:px-8">
                <div class="mx-auto max-w-2xl lg:text-center">
                    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Here is a framework for a
                        course on the concept of God as the name "I am."</p>
                </div>
                <div class="mx-auto max-w-2xl lg:max-w-none">
                    <div class="mx-auto py-8 max-w-7xl sm:px-6 lg:px-8">
                        <p class="leading-8 text-gray-600 mt-6">
                            The course will aim at exploring the psychological aspects of the concept of God as the name "I
                            am" and contributing to an interdisciplinary dialogue between philosophy and psychology. With
                            this course, students will have a better understanding of how different belief systems view God
                            and its implications on individuals' lives. They will gain the ability to comprehend the diverse
                            ways individuals respond to and interact with God and the impact on personal development,
                            ethical principles, and devotional practices. Ultimately, the course will enable students to
                            reflect on the concept of God in their personal lives and broader communities.
                        </p>
                    </div>
                    <CourseCard v-for="(item, index) in courses" :key="index" :id="item.id" :title="item.name" :content="item.description"
                        :price="item.amount" :slug="item.slug" :image="item.image" />
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import CourseCard from '@/Components/CourseCard.vue';
import HeaderSection from '@/Components/HeaderSection.vue'

defineProps({
    courses: {
        type: Array,
    },
});

</script>
<style scoped>
.carousel__item {
    min-height: 300px;
    width: 100%;
    background-color: var(--vc-clr-white);
    color: var(--vc-clr-primary);
    border-radius: 8px;
}

.carousel__slide {
    padding: 10px;
}

.carousel__prev,
.carousel__next {
    box-sizing: content-box;
    border: 5px solid white;
}</style>