<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Tiptap from '@/Components/Tiptap.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/Shared/PrimaryButton.vue';
import SecondaryButton from '@/Components/Shared/SecondaryButton.vue';
import { ref } from 'vue';
import HeaderSection from '@/Components/HeaderSection.vue';
import FooterSection from '@/Components/FooterSection.vue';

const props = defineProps({
    nextTopic: Object,
    isLastTopic: Boolean,
    assessment: Object,
    course_id: Number,
    current_score: Number,
    no_of_items: Number
})

function next() {
    router.get(route('home.show-lesson', props.nextTopic.slug))
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
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="font-bold leading-6 text-primary">Score</dt>
                            <dd class="mt-1 leading-6 sm:col-span-2 sm:mt-0">{{ current_score }} / {{ no_of_items }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
            <div class="flex justify-center px-2 mt-4">
                <a :href="route('register') ">
                    <PrimaryButton type="button">
                        Sign in to save your progress
                    </PrimaryButton>
                </a>
                <secondary-button v-if="!isLastTopic" class="text-gray-dark ml-3" type="button" @click="next">
                    Next Topic
                </secondary-button>
            </div>

        </div>
    </div>
    <FooterSection />
</template>
