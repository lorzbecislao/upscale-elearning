<script setup>
import {Head, router} from '@inertiajs/vue3'
import {AcademicCapIcon, ArrowCircleRightIcon, ArrowLeftIcon} from "@heroicons/vue/outline"
import SecondaryButton from '@/Components/Shared/SecondaryButton.vue'
import StudentLayout from "@/Layouts/StudentLayout.vue"
import {CheckCircleIcon} from "@heroicons/vue/solid"
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue"

const props = defineProps({
  nextTopic: Object,
  isLastTopic: Boolean,
  topic: Object,
  assessment: Object,
  course_id: Number,
  result: Object
})

function handleNext() {
  router.visit(props.topic.next_topic_route)
}

const pageTitle = props.assessment.title

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
                        <p class="mt-2 text-3xl font-heading font-bold tracking-tight text-gray-900 sm:text-4xl">
                          Result - {{ assessment.title }}
                        </p>
                        <p class="mt-2 font-heading text-base leading-8 text-gray-600">{{ topic.title }}</p>
                    </div>
                </div>
                <div class="px-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="mt-4 border-t border-gray-100">
                        <dl class="divide-y divide-gray-100">
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="font-bold leading-6 text-primary">Assessment Title</dt>
                                <dd class="mt-1 leading-6 sm:col-span-2 sm:mt-0">{{ assessment.title }}
                                </dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="font-bold leading-6 text-primary">Assessment Type</dt>
                                <dd class="mt-1 leading-6 sm:col-span-2 sm:mt-0">{{
                                    assessment.type == 1 ? 'Practical'
                                    : 'Quiz'
                                    }}
                                </dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="font-bold leading-6 text-primary">Instruction</dt>
                                <dd class="mt-1 leading-6 sm:col-span-2 sm:mt-0">{{ assessment.instruction }}
                                </dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="font-bold leading-6 text-primary">Score</dt>
                                <dd class="mt-1 leading-6 sm:col-span-2 sm:mt-0">{{ result.score }} / {{
                                    result.total_items }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
                <div class="border-t">
                    <div class="flex justify-center gap-4 px-2 mt-4">
                        <secondary-button class="font-heading text-gray-dark text-sm" @click="handleViewCourse">
                            <academic-cap-icon class="w-6 h-6" />
                            View Course
                        </secondary-button>
                        <primary-button class="!bg-secondary font-heading text-sm h-full">
                            <check-circle-icon class="w-5 h-5" />
                            Completed
                        </primary-button>
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
