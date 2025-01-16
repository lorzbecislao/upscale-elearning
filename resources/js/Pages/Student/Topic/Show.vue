<script setup>
import {AcademicCapIcon, ArrowLeftIcon, ArrowCircleRightIcon} from "@heroicons/vue/outline"
import {CheckCircleIcon} from "@heroicons/vue/solid"
import {Head, router} from "@inertiajs/vue3"
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue"
import SecondaryButton from "@/Components/Shared/SecondaryButton.vue"
import StudentLayout from "@/Layouts/StudentLayout.vue"
import Tiptap from '@/Components/Tiptap.vue';

const props = defineProps({
  topic: Object
})

const pageTitle = props.topic.title

function handleNext() {
  router.visit(props.topic.next_topic_route)
}

function handleMarkAsComplete() {
  router.post(route('topics.markAsComplete', [props.topic.course.student_course_id, props.topic.id]))
}

function handleViewCourse() {
  router.visit(props.topic.course.show_route)
}
</script>
<template>
    <student-layout>

        <Head :title="pageTitle" />
        <div class="py-12">
            <div class="max-w-7xl mx-auto">
                <div class="cursor-pointer inline-flex gap-2" @click="handleViewCourse">
                    <arrow-left-icon class="w-6 h-6 text-black" />
                    <p class="text-base font-inter font-semibold text-gray-dark"> Back</p>
                </div>
                <div class="flex items-center pt-6">
                    <div>
                        <img v-if="topic.course.image_url" class="h-48 w-48 md:h-56 md:w-56"
                            :src="topic.course.image_url" alt="" />
                        <img v-else class="h-48 w-48 border object-cover rounded-full " src="/images/placeholder.jpeg"
                            alt="" />
                    </div>
                    <div class="flex-1 ml-3">
                        <p class="mt-2 text-3xl font-heading font-bold tracking-tight text-gray-900 sm:text-4xl">{{
                            topic.title
                            }}</p>
                        <p class="mt-2 font-heading text-base leading-8 text-gray-600">{{ topic.course.name }}</p>
                    </div>
                </div>
                <div class="py-10">
                    <tiptap v-model="topic.content" :is-editable="false" />
                </div>

                <div class="border-t">
                    <div class="flex justify-center gap-6 py-6">
                        <secondary-button class="font-heading text-gray-dark text-sm" @click="handleViewCourse">
                            <academic-cap-icon class="w-6 h-6" />
                            View Course
                        </secondary-button>
                        <div v-if="topic.course.enrolled">
                            <primary-button v-if="!topic.completed" class="font-heading text-sm h-full"
                                @click="handleMarkAsComplete">
                                Mark as complete
                            </primary-button>
                            <primary-button v-else class="!bg-secondary font-heading text-sm h-full">
                                <check-circle-icon class="w-5 h-5" />
                                Completed
                            </primary-button>
                        </div>
                        <secondary-button v-if="topic.next_topic_route" class="font-heading text-gray-dark text-sm"
                            @click="handleNext()">
                            <arrow-circle-right-icon class="w-6 h-6" />
                            Next Topic
                        </secondary-button>
                    </div>
                </div>
            </div>
        </div>
    </student-layout>
</template>