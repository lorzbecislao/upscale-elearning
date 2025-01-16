<script setup>
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import PrimaryButton from '@/Components/Shared/PrimaryButton.vue';
import AddAssessmentModal from '@/Components/Modal/AddAssessmentModal.vue'
import DataTable from '@/Pages/Admin/Assessment/DataTable.vue'
import SearchInput from "@/Components/Shared/SearchInput.vue"

import { ref, computed } from "vue"

const modalOpen = ref(false)

defineProps({
    courses: { type: Array, default: () => [] },
});

const search = ref(null);
const datatable = ref(null);

function refreshDataTable() {
    if (datatable.value) {
        datatable.value.loadData(1);
    }
}

function handleSearch(text) {
    datatable.value.handleSearch(text)
}

function handleCreate() {
    // router.visit(route('admin.assessments.create'))
    modalOpen.value = true
}

const showPortalBreadcrumb = true

</script>

<template>

    <Head title="Assessments" />
    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Assessments</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto">
                <div class="flex">
                    <search-input v-model="search" class="flex-1" placeholder="Search"
                        @update:modelValue="handleSearch($event)" size="large" />
                    <primary-button @click="handleCreate" class="ml-4 mb-4">
                        Create New Assessment
                    </primary-button>
                </div>
                <div class="bg-white ring-1 ring-gray-300 p-4 overflow-hidden shadow-sm sm:rounded-lg">
                    <DataTable ref="datatable" :courses="courses" />
                </div>
            </div>
        </div>
        <AddAssessmentModal :courses="courses" :open="modalOpen" @close="modalOpen = false"
            @refreshDataTable="refreshDataTable" />
    </AdminLayout>
    <Teleport v-if="showPortalBreadcrumb" to="#portal-breadcrumb">
        <h4 class="text-2xl font-semibold font-heading">Assessments</h4>
    </Teleport>
</template>
