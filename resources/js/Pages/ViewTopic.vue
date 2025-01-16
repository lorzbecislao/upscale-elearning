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
    topic: Object,
    nextTopic: Object,
    assessment: Object,
    isLastTopic: Boolean
})

function nextLesson() {
    if (props.assessment) {
        router.get(route('home.show-assessment', props.assessment.id))
    } else {
        router.get(route('home.show-lesson', props.nextTopic.slug))
    }
}

</script>

<template>

    <Head title="Upscale - Elevate your career with web development skills" />
    <HeaderSection />
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <p class="ml-2 text-2xl mb-5 font-bold">{{ topic.title }}</p>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <tiptap v-model="topic.content" :is-editable="false" />
            </div>
            <div class="flex justify-center px-2 mt-4">
                <a :href="route('register')">
                    <PrimaryButton type="button">
                        Sign in to save your progress
                    </PrimaryButton>
                </a>
                <secondary-button v-if="assessment || !isLastTopic" class="text-gray-dark ml-3" type="button"
                    @click="nextLesson">
                    Next Lesson
                </secondary-button>
            </div>

        </div>
    </div>
    <FooterSection />
</template>
