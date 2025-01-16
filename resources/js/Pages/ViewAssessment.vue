<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Tiptap from '@/Components/Tiptap.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/Shared/PrimaryButton.vue';
import SecondaryButton from '@/Components/Shared/SecondaryButton.vue';
import { ref } from 'vue';
import HeaderSection from '@/Components/HeaderSection.vue';
import FooterSection from '@/Components/FooterSection.vue';
import { AcademicCapIcon, ArrowLeftIcon, ArrowCircleRightIcon } from "@heroicons/vue/outline"

const props = defineProps({
    topic: Object,
    nextTopic: Object,
    isLastTopic: Boolean,
    assessment: Object,
    course_id: Number
})

function start() {
    router.get(route('home.start-assessment', props.assessment.id))
}

function takeLater() {
    router.get(route('home.topic-list', props.course_id))
}

function handleViewCourse() {
    router.visit(route('home.topic-list', props.topic.course.id));
}

</script>

<template>

    <Head title="Upscale - Elevate your career with web development skills" />
    <HeaderSection />
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                            <dd class="mt-1 leading-6 sm:col-span-2 sm:mt-0">{{ assessment.type == 1 ? 'Practical'
                                : 'Quiz' }}
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
            <div v-if="assessment.type == 2" class="flex justify-center px-2 mt-4">
                <secondary-button class="text-gray-dark mr-3 !px-12" type="button" @click="takeLater">
                    Take later
                </secondary-button>
                <a :href="route('register') ">
                    <PrimaryButton type="button">
                        Sign in to save your progress
                    </PrimaryButton>
                </a>
                <secondary-button  class="text-gray-dark ml-3" type="button" @click="start">
                    Start Assessment
                </secondary-button>
            </div>
            <div v-else class="flex justify-center px-2 mt-4">
                <secondary-button class="text-gray-dark mr-3 !px-12" type="button" @click="handleViewCourse">
                    <academic-cap-icon class="w-6 h-6" />
                    View Course
                </secondary-button>
                <a :href="route('register')">
                    <PrimaryButton type="button">
                        Sign in to save your progress
                    </PrimaryButton>
                </a>
                <secondary-button class="text-gray-dark ml-3" type="button" @click="start">
                    Start Assessment
                </secondary-button>
            </div>

        </div>
    </div>
    <FooterSection />
</template>
