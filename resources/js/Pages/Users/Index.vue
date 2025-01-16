<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import DataTable from '@/Pages/Users/DataTable.vue';
import SearchInput from "@/Components/Shared/SearchInput.vue"
import {ref, computed} from "vue"
import PrimaryButton from '@/Components/Shared/PrimaryButton.vue';
import AddAdminModal from '@/Components/Modal/AddAdminModal.vue'

const search = ref(null);
const datatable = ref(null);
const modalOpen = ref(false);

function refreshDataTable() {
  if (datatable.value) {
     datatable.value.loadData(1);
  }
}

function handleSearch(text) {
  datatable.value.handleSearch(text)
}

</script>

<template>

    <Head title="Users" />
    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Users</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex">
                    <search-input v-model="search" class="flex-1" placeholder="Search"
                        @update:modelValue="handleSearch($event)" size="large" />
                    <primary-button @click="modalOpen = true" class="ml-4 mb-4">
                        Add New Admin
                    </primary-button>
                </div>

                <DataTable ref="datatable" />
            </div>
        </div>
        <AddAdminModal :open="modalOpen" @close="modalOpen = false" @refreshDataTable="refreshDataTable" />
    </AdminLayout>
</template>
