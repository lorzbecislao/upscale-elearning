<script setup>
import { Head, Link, useForm, router } from '@inertiajs/vue3'
import BookOpenIcon from "@/Components/Icon/BookOpenIcon.vue"
import PencilSquareIcon from "@/Components/Icon/PencilSquareIcon.vue"
import PuzzlePieceIcon from "@/Components/Icon/PuzzlePieceIcon.vue"

defineProps({
    topics: {
        type: Array,
    },
    course: {
        type: Object,
    },
});


const show = (slug, type) => {
    if (type == 'topic') {
        router.get(route('home.show-lesson', slug))
    } else {
        
    }
};

const showAssessment = (id, type) => {
    router.get(route('home.show-assessment', id))
};

</script>

<template>

    <Head title="Topic List" />
    <div class="bg-gray-100 py-24 h-full sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl mb-12 lg:text-center">
                <img class="mx-auto h-48 w-48 rounded-full md:h-56 md:w-56" :src="course.image_url" alt="" />
                <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{course.name}} Course</p>
                <p class="mt-6 text-lg leading-8 text-gray-600">{{ course.description }}</p>
            </div>
            <template v-for="title in Array.from(new Set(topics.map(topic => topic.title_id)))" :key="title">
                <div
                    class="bg-white shadow rounded-lg dark:bg-gray-800 dark:ring-1 dark:ring-white/10 dark:ring-inset mb-10">
                    <div class="p-8 pb-0 px-6 pt-4 pb-4 border-b dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-300 hover:underline w-fit">
                            {{ topics.find(topic => topic.title_id === title).title_name }}
                        </h3>
                    </div>
                    <div class="p-8 py-4 px-4">
                        <div class="flex flex-col space-y-3">
                            <template v-for="topic in topics" :key="topic.id">
                                <div @click="show(topic.slug, 'topic')"
                                    class="flex items-center cursor-pointer flex-shrink-1 group hover:bg-gray-100 dark:hover:bg-gray-700 px-2 rounded-md transition ease-in-out  hover:transition-colors">
                                    <BookOpenIcon class="text-gray-800 dark:text-gray-300" />
                                    <p class="ml-3 text-gray-800 text-lg dark:text-gray-300">{{ topic.title}}</p>
                                </div>
                                <div @click="showAssessment(assessment.id)" v-if="topic.assessments.length > 0" v-for="assessment in topic.assessments"
                                    :key="assessment.id"
                                    class="flex items-center cursor-pointer flex-shrink-1 group hover:bg-gray-100 dark:hover:bg-gray-700 px-2 rounded-md transition ease-in-out  hover:transition-colors">
                                    <PencilSquareIcon v-if="assessment.type == 2"
                                        class="text-gray-800 dark:text-gray-300" />
                                    <PuzzlePieceIcon v-else
                                        class="text-gray-800 dark:text-gray-300" />
                                    <p class="ml-3 text-gray-800 text-lg dark:text-gray-300">{{ assessment.title }}</p>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </template>

        </div>
    </div>
</template>