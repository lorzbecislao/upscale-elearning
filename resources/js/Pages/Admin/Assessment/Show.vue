<script setup>
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import PrimaryButton from '@/Components/Shared/PrimaryButton.vue';
import AddQuestionModal from '@/Components/Modal/AddQuestionModal.vue'
import QuestionDataTable from '@/Pages/Admin/Assessment/QuestionDataTable.vue'
import SearchInput from "@/Components/Shared/SearchInput.vue"
import CreatePractical from '@/Pages/Admin/Assessment/CreatePractical.vue'

import { ref, computed } from "vue"

const modalOpen = ref(false)

defineProps({
    assessment: { type: Object, default: () => {} },
});


const datatable = ref(null);

function handleCreate() {
    // router.visit(route('admin.assessments.create'))
    modalOpen.value = true
}

function refreshDataTable() {
    if (datatable.value) {
        datatable.value.loadData(1)
    }
}

const showPortalBreadcrumb = true

</script>

<template>

    <Head title="Assessments Details" />
    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Assessments</h2>
        </template>

        <div class="py-12">
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
                                <dd class="mt-1 leading-6 sm:col-span-2 sm:mt-0">{{ assessment.after_topic.title}}
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
                <div v-if="assessment.type === 2">
                    <div class="mt-4 flex justify-end">
                        <primary-button @click="handleCreate" class="ml-4 mb-4">
                            Add New Question
                        </primary-button>
                    </div>
                    <div class="bg-white ring-1 ring-gray-300 p-4 overflow-hidden shadow-sm sm:rounded-lg">
                        <QuestionDataTable ref="datatable" :assessment="assessment" />
                    </div>
                </div>
                <div v-else>
                    <CreatePractical :assessment="assessment" />
                </div>
            </div>
        </div>
        <AddQuestionModal :assessment="assessment" :open="modalOpen" @close="modalOpen = false"
            @refreshDataTable="refreshDataTable" />
    </AdminLayout>
    <Teleport v-if="showPortalBreadcrumb" to="#portal-breadcrumb">
        <h4 class="text-2xl font-semibold font-heading">Assessments Details</h4>
    </Teleport>
</template>
