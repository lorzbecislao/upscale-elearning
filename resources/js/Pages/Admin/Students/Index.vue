<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import DataTable from '@/Pages/Admin/Students/DataTable.vue';
import SearchInput from "@/Components/Shared/SearchInput.vue"
import { ref, computed } from "vue"

const props = defineProps({
    programs: Array
})

const search = ref(null);
const datatable = ref(null);


function handleSearch(text) {
  datatable.value.handleSearch(text)
}


</script>

<template>

    <Head title="Users" />
    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Students</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <search-input v-model="search"
                        class="flex-1"
                        placeholder="Search"
                        @update:modelValue="handleSearch($event)"
                        size="large"/>

                <DataTable ref="datatable" :programs="programs"/>                    
            </div>
        </div>
    </AdminLayout>
</template>
