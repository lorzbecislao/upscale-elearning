<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Tiptap from '@/Components/Tiptap.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/Shared/PrimaryButton.vue';
import { ref } from 'vue';

const props = defineProps({
    topic: Object,
    course: Object

})

const form = useForm({
    title: null,
    content: props.topic.content ? props.topic.content : 'Start editing your own content by editing here',
    topic_id: props.topic.id
})

const modalOpen = ref(false)

function submitForm() {
    form.post(route('admin.topics.update', props.topic.id), {
        preserveScroll: true,
            onSuccess: () => {
        }
    })
}

function handleBack() {
    router.visit(route('admin.courses.show', props.course.slug))
}

</script>

<template>
    <Head title="Edit" />
    <!-- <AuthenticatedLayout> -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <button @click="handleBack" class="inline-flex items-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-3 w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
                </svg>
                Back
            </button>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form @submit.prevent="submitForm" class="space-y-8">
                    <!-- <input type="text" class="w-full border border-gray-400" placeholder="Title here" required
                        v-model="form.title"> -->
                    <tiptap v-model="form.content" />
                    <div class="flex justify-end">
                        <primary-button @click="modalOpen = true" class="!px-12">
                            Save
                        </primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- </AuthenticatedLayout> -->
</template>
