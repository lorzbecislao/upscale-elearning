<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Tiptap from '@/Components/Tiptap.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    title: null,
    content: null
})

function submitForm() {
    form.post(route('lesson.store'), {
        preserveScroll: true,
        onSuccess: () => {
            alert('Success');
        }
    })
}

</script>

<template>
    <Head title="Create Lesson" />
    <!-- <AuthenticatedLayout> -->
        <div class="py-12">
            <h1>Test</h1>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form @submit.prevent="submitForm" class="space-y-8">
                        <input type="text" class="w-full border border-gray-400" placeholder="Title here" required v-model="form.title">
                        <tiptap v-model="form.content"/>
                        <div class="flex justify-end">
                            <button type="submit" class="rounded-md bg-indigo-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                Save Lesson
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <!-- </AuthenticatedLayout> -->
</template>
