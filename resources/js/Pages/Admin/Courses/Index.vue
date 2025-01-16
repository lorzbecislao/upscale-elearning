<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import PrimaryButton from '@/Components/Shared/PrimaryButton.vue';
import AddCourseModal from '@/Components/Modal/AddCourseModal.vue'
import DataTable from '@/Pages/Admin/Courses/DataTable.vue'
import SearchInput from "@/Components/Shared/SearchInput.vue"

import {ref, computed} from "vue"

const modalOpen = ref(false)

defineProps({
  courses: {type: Array, default: () => []},
  errors: Object
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

const showPortalBreadcrumb = true

</script>

<template>
  <Head title="Courses"/>
  <AdminLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Courses</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto">
        <div class="flex">
          <search-input v-model="search"
                        class="flex-1"
                        placeholder="Search"
                        @update:modelValue="handleSearch($event)"
                        size="large"/>
          <primary-button @click="modalOpen = true" class="ml-4 mb-4">
            Add Course
          </primary-button>
        </div>
        <div class="bg-white ring-1 ring-gray-300 p-4 overflow-hidden shadow-sm sm:rounded-lg">
          <DataTable ref="datatable"/>
        </div>
      </div>
    </div>
    <AddCourseModal :open="modalOpen"
                    @close="modalOpen = false"
                    @refreshDataTable="refreshDataTable"/>
  </AdminLayout>
  <Teleport v-if="showPortalBreadcrumb" to="#portal-breadcrumb">
    <h4 class="text-2xl font-semibold font-heading">Courses</h4>
  </Teleport>
</template>
