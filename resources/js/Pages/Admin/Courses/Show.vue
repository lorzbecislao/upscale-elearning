<script setup>
import TopicsDataTable from './TopicsDataTable.vue';
import Breadcrumbs from "@/Components/Shared/Breadcrumbs.vue"
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import SearchInput from "@/Components/Shared/SearchInput.vue"
import PrimaryButton from '@/Components/Shared/PrimaryButton.vue';
import AddTopicModal from '@/Components/Modal/AddTopicModal.vue'

const props = defineProps({
    course: Object
})

const showPortalBreadcrumb = ref(true)
const modalOpen = ref(false)

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

const topics = [
  {
    title_id: 1,
    title_name: 'Intoduction',
    lesson: 'How This Course Will Work'
  },
  {
    title_id: 1,
    title_name: 'Intoduction',
    lesson: 'A Quick Review'
  },
  {
    title_id: 2,
    title_name: 'Organizing Your Javascript Code',
    lesson: 'Organizing Your Javascript Code Introduction'
  },
  {
    title_id: 2,
    title_name: 'Organizing Your Javascript Code',
    lesson: 'Objects and Object Constructors'
  },
  {
    title_id: 2,
    title_name: 'Organizing Your Javascript Code',
    lesson: 'Project: Library'
  },
  {
    title_id: 3,
    title_name: 'Asynchronous JavaScript and APIs',
    lesson: 'Asynchronous Code'
  },
  
]

const pageTitle = computed(() => `Courses - ${props.course.name}`);

</script>

<template>
    <Head :title="pageTitle" />
    
    <AdminLayout>
         <div class="py-12">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center">
                    <img class="h-48 w-48 md:h-56 md:w-56" :src="course.image_url" alt="" />
                    <div class="flex-1 ml-3">
                        <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ course.name }}</p>
                        <p class="mt-6 text-lg leading-8 text-gray-600">{{ course.description }}</p>
                    </div>
                </div>
                <div class="flex mt-5">
                    <search-input v-model="search"
                        class="flex-1"
                        placeholder="Search"
                        @update:modelValue="handleSearch($event)"
                        size="large"/>
                    <primary-button @click="modalOpen = true" class="ml-4 mb-4">
                        Add Topic
                    </primary-button>
                </div>
                <div class="ring-1 ring-gray-200 px-5 py-1 rounded-md">
                    <TopicsDataTable :course="course" ref="datatable"/>
                </div>
            </div>
         </div>

        <AddTopicModal :open="modalOpen"
            :course="course"
            @close="modalOpen = false"
            @refreshDataTable="refreshDataTable"/> 
    </AdminLayout>
    <Teleport v-if="showPortalBreadcrumb" to="#portal-breadcrumb">
        <breadcrumbs :levels="2" :level1="{ name: 'Courses', route: 'admin.courses' }"
            :level2="{ name: course.name, route: 'admin.courses.show', route_id: course.slug }" />
    </Teleport>
</template>