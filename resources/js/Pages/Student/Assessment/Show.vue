<script setup>
import {Head, router} from "@inertiajs/vue3"
import {AcademicCapIcon, ClockIcon, ArrowLeftIcon, ArrowCircleRightIcon} from "@heroicons/vue/outline"
import {CheckCircleIcon} from "@heroicons/vue/solid"
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue"
import SecondaryButton from "@/Components/Shared/SecondaryButton.vue"
import StudentLayout from "@/Layouts/StudentLayout.vue"

const props = defineProps({
  assessment: Object,
  topic: Object
})

const pageTitle = props.assessment.title

function handleViewCourse() {
  router.visit(props.topic.course.show_route)
}

function handleStart() {
  router.post(route('assessment.start', props.assessment.id))
}

function handleViewResult() {
  router.visit(route('assessment.result', props.assessment.id))
}

function handleNext() {
  router.visit(props.topic.next_topic_route)
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
                            assessment.title
                            }}</p>
                        <p class="mt-2 font-heading text-base leading-8 text-gray-600">{{ topic.title }}</p>
                    </div>
                </div>
            </div>

            <div class="px-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="mt-4">
                    <dl class="divide-y divide-gray-100">
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="font-bold leading-6 text-primary font-heading">Assessment Title</dt>
                            <dd class="mt-1 leading-6 sm:col-span-2 sm:mt-0">{{ assessment.title }}
                            </dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="font-bold leading-6 text-primary font-heading">Assessment Type</dt>
                            <dd class="mt-1 leading-6 sm:col-span-2 sm:mt-0">{{
                                assessment.type == 1 ? 'Practical'
                                : 'Quiz'
                                }}
                            </dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="font-bold leading-6 text-primary font-heading">Instruction</dt>
                            <dd class="mt-1 leading-6 sm:col-span-2 sm:mt-0">{{ assessment.instruction }}
                            </dd>
                        </div>
                    </dl>
                </div>

            </div>
            <div class="border-t">

                <div v-if="assessment.type !== 1 && topic.course.enrolled" class="flex justify-center gap-4 px-2 mt-4">
                    <secondary-button class="font-heading text-gray-dark text-sm" @click="handleViewCourse">
                        <academic-cap-icon class="2-5 h-5" />
                        View Course
                    </secondary-button>

                    <primary-button v-if="!assessment.completed" class="font-heading text-gray-dark text-sm"
                        @click="handleStart">
                        <check-circle-icon class="w-5 h-5" />
                        Start Assessment
                    </primary-button>
                    <div v-if="assessment.completed" class="flex gap-6">
                        <primary-button class="!bg-secondary font-heading text-sm h-full">
                            <check-circle-icon class="w-5 h-5" />
                            Completed
                        </primary-button>
                        <secondary-button class="font-heading text-gray-dark text-sm" @click="handleViewResult()">
                            <arrow-circle-right-icon class="w-6 h-6" />
                            View Result
                        </secondary-button>
                    </div>

                </div>



                <!-- If practical -->
                <div v-else-if="assessment.type == 1 && topic.course.enrolled"
                    class="flex justify-center gap-4 px-2 mt-4">
                    <secondary-button class="font-heading text-gray-dark text-sm" @click="handleViewCourse">
                        <clock-icon v-if="!assessment.completed" class="w-5 h-5" />
                        <academic-cap-icon v-else class="2-5 h-5" />
                        View Course
                    </secondary-button>
                    <primary-button v-if="!assessment.completed && assessment.type == 1 "
                        class="font-heading text-gray-dark text-sm" @click="handleStart">
                        <check-circle-icon class="w-5 h-5" />
                        Start Assessment
                    </primary-button>
                    <primary-button v-else class="!bg-secondary font-heading text-sm h-full">
                        <check-circle-icon class="w-5 h-5" />
                        Completed
                    </primary-button>
                </div>

                <div v-else class="flex justify-center gap-4 mt-4 px-2">
                    <secondary-button class="font-heading text-gray-dark text-sm" @click="handleViewCourse">
                        <academic-cap-icon class="w-6 h-6" />
                        View Course
                    </secondary-button>
                    <secondary-button v-if="topic.next_topic_route" class="font-heading text-gray-dark text-sm"
                        @click="handleNext()">
                        <arrow-circle-right-icon class="w-6 h-6" />
                        Next Topic
                    </secondary-button>
                </div>
            </div>
        </div>
    </student-layout>
</template>