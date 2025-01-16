<script setup>
import { AcademicCapIcon, ArrowLeftIcon, ArrowCircleRightIcon } from "@heroicons/vue/outline"
import { CheckCircleIcon } from "@heroicons/vue/solid"
import { Head, router } from "@inertiajs/vue3"
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue"
import SecondaryButton from "@/Components/Shared/SecondaryButton.vue"
import StudentLayout from "@/Layouts/StudentLayout.vue"
import Tiptap from '@/Components/Tiptap.vue';

const props = defineProps({
    topic: Object,
    assessment: Object
})

const pageTitle = props.topic.title

function handleNext() {
    router.visit(props.topic.next_topic_route)
}

function handleMarkAsComplete() {
    router.post(route('topics.markPracticalCompleted', props.assessment.id))
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

                <div class="max-w-7xl mx-auto">
                    <div class="px-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="mt-4 border-t border-gray-100">
                            <dl class="divide-y divide-gray-100">
                                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="font-bold leading-6 text-primary">Course</dt>
                                    <dd class="mt-1 leading-6 sm:col-span-2 sm:mt-0">{{ assessment.course.name }}
                                    </dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="font-bold leading-6 text-primary">Topic</dt>
                                    <dd class="mt-1 leading-6 sm:col-span-2 sm:mt-0">{{ assessment.after_topic.title }}
                                    </dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="font-bold leading-6 text-primary">Assessment Type</dt>
                                    <dd class="mt-1 leading-6 sm:col-span-2 sm:mt-0">Practical
                                    </dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="font-bold leading-6 text-primary">Instruction</dt>
                                    <dd class="mt-1 leading-6 sm:col-span-2 sm:mt-0">{{ assessment.instruction }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <tiptap v-model="assessment.content" :is-editable="false" />
                </div>

                <div class="border-t">
                    <div class="flex justify-center gap-6 py-6">
                        <secondary-button class="font-heading text-gray-dark text-sm" @click="handleViewCourse">
                            <academic-cap-icon class="w-6 h-6" />
                            View Course
                        </secondary-button>
                        <div v-if="topic.course.enrolled">
                            <primary-button v-if="!assessment.completed" class="font-heading text-sm h-full"
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