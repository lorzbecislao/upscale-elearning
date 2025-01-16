<script setup>
import {Head, router} from "@inertiajs/vue3"
import {CheckCircleIcon} from "@heroicons/vue/solid"
import BookOpenIcon from "@/Components/Icon/BookOpenIcon.vue"
import StudentLayout from "@/Layouts/StudentLayout.vue"
import PencilSquareIcon from "@/Components/Icon/PencilSquareIcon.vue"
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue"
import PuzzlePieceIcon from "@/Components/Icon/PuzzlePieceIcon.vue"

const props = defineProps({
  course: Object,
  topics: Array,
})

function handleView(data, is_assessment) {
  if (!is_assessment) {
    router.visit(route('topics.show', data.slug))
  } else {
    router.visit(route('assessment.show', data.id))
  }
}


</script>
<template>
    <student-layout>

        <Head :title="course.name" />
        <div class="py-24 h-full sm:py-32">
            <div class="max-w-7xl mx-auto">
                <div>
                    <div>
                        <img v-if="course.image_url" class="h-48 w-48 md:h-56 md:w-56 rounded-full mx-auto"
                            :src="course.image_url" alt="" />
                        <img v-else class="mx-auto h-48 w-48 md:h-56 md:w-56 border object-cover rounded-full "
                            src="/images/placeholder.jpeg" alt="" />
                    </div>
                    <div class="flex-1 ml-3 text-center">
                        <p
                            class="mt-2 text-3xl font-heading font-bold tracking-tight text-gray-900 sm:text-4xl text-center">
                            {{ course.name }}
                        </p>
                    </div>
                    <p class="text-base text-gray-700 font-bold font-heading mt-2">Overview</p>
                    <p class="mt-2 font-heading text-base leading-8 text-gray-600">{{ course.description }}</p>
                </div>
                <template v-for="title in Array.from(new Set(topics.map(topic => topic.title_id)))" :key="title">
                    <div
                        class="bg-white shadow rounded-lg dark:bg-gray-800 dark:ring-1 dark:ring-white/10 dark:ring-inset mb-10 mt-6">
                        <div class="p-8 px-6 pt-4 pb-4 border-b dark:border-gray-700">
                            <h3
                                class="text-lg font-medium text-gray-800 dark:text-gray-300 hover:underline w-fit font-heading">
                                {{ topics.find(topic => topic.title_id === title).title_name }}
                            </h3>
                        </div>
                        <div class="p-8 py-4 px-4">
                            <div class="flex flex-col space-y-3">
                                <template v-for="topic in topics" :key="topic.id">
                                    <div
                                        class="flex items-center justify-between cursor-pointer flex-shrink-1 group hover:bg-gray-100 dark:hover:bg-gray-700 px-2 rounded-md transition ease-in-out  hover:transition-colors">
                                        <div class="flex items-center" @click="handleView(topic, false)">
                                            <BookOpenIcon class="text-gray-800 dark:text-gray-300" />
                                            <p class="ml-3 text-gray-800 text-lg dark:text-gray-300 font-heading">{{
                                                topic.title }}</p>
                                        </div>
                                        <check-circle-icon class="w-6 h-6"
                                            :class="topic.completed ? 'text-secondary' : 'text-white'" />
                                    </div>
                                    <div v-if="topic.assessments && topic.assessments.length > 0"
                                        v-for="assessment in topic.assessments" :key="assessment.id"
                                        class="flex items-center justify-between cursor-pointer flex-shrink-1 group hover:bg-gray-100 dark:hover:bg-gray-700 px-2 rounded-md transition ease-in-out  hover:transition-colors"
                                        @click="handleView(assessment, true)">
                                        <div class="flex items-center">
                                            <PencilSquareIcon v-if="assessment.type == 2"
                                                class="text-gray-800 dark:text-gray-300" />
                                            <PuzzlePieceIcon v-else class="text-gray-800 dark:text-gray-300" />
                                            <p class="ml-3 text-gray-800 text-lg dark:text-gray-300 font-heading">{{
                                                assessment.title }}</p>
                                        </div>
                                        <check-circle-icon class="w-6 h-6"
                                            :class="assessment.completed ? 'text-secondary' : 'text-white'" />
                                    </div>

                                </template>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </student-layout>
</template>