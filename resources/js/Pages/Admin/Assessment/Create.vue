<script setup>
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import PrimaryButton from '@/Components/Shared/PrimaryButton.vue';
import { ref, computed } from "vue"
import TextInput from "@/Components/Shared/TextInput.vue"


defineProps({
    courses: { type: Array, default: () => [] },
});


function handleCreate() {
    router.visit(route('admin.assessments.create'))
}

const showPortalBreadcrumb = true

const selectedType = ref(1);

function handleChangeType(id) {
    selectedType.value = id;
}

const assessmentTypes = [
    { id: 1, title: 'Quiz' },
    { id: 2, title: 'Practical' },
]

const options = [
    { id: 1, label: 'A' },
    { id: 2, label: 'B' },
    { id: 3, label: 'C' },
    { id: 4, label: 'D' },
]

const questions = ref([{ text: '', options: ['', '', '', ''], rightAnswer: '' }]);

function addQuestion() {
    questions.value.push({ text: '', options: ['', '', '', ''], rightAnswer: '' });
}

function handleRightAnswer(question, option) {
    question.rightAnswer = option;
}

</script>

<template>

    <Head title="Create Assessment" />
    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Create Assessment</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white px-8 p-4 overflow-hidden shadow-sm sm:rounded-lg">
                   
                </div>
            </div>
        </div>
        <!-- <AddAssessmentModal :courses="courses" :open="modalOpen" @close="modalOpen = false"
            @refreshDataTable="refreshDataTable" /> -->
    </AdminLayout>
    <Teleport v-if="showPortalBreadcrumb" to="#portal-breadcrumb">
        <h4 class="text-2xl font-semibold font-heading">Create Assessment</h4>
    </Teleport>
</template>
