<script setup>

import { ref, onMounted, watch } from 'vue';
import { router, useForm } from '@inertiajs/vue3'
import Pagination from '@/Components/Shared/Pagination.vue';
import SearchInput from "@/Components/Shared/SearchInput.vue"
import TrashIcon from '@/Components/Icon/TrashIcon.vue';
import { PencilAltIcon } from "@heroicons/vue/outline"
import DeleteConfirmModal from "@/Components/Modal/DeleteConfirmModal.vue"
import FlashNotificationsFrontEnd from "@/Components/Shared/FlashNotificationsFrontEnd.vue"
import Toggle from "@/Components/Shared/Toggle.vue"
import EditCourseModal from '@/Components/Modal/EditCourseModal.vue'

const props = defineProps({
})

onMounted(() => {
    loadData();
})

const search = ref(null);
const sortColumn = ref('id');
const sortDirection = ref('asc');
const courses = ref([]);
const openDelete = ref(false);
const openEdit = ref(false);
const selectedCourse = ref(null)
const flashNotifShow = ref(false)
const flashNotifInfos = { icon: 'check', header: null }

const loadData = (page = 1) => {
    axios.get(`/admin/courses/data-table`, {
        params: {
            page: page,
            search: search.value,
            sort_column: sortColumn.value,
            sort_direction: sortDirection.value
        }
    })
        .then(response => {
            courses.value = response.data;
        })
        .catch(error => {
            console.error(error);
        });
};

function handleSearch(text) {
    search.value = text
    loadData(1)
}

watch([search, sortColumn, sortDirection], () => {
    loadData();
}, { immediate: true });

defineExpose({
    handleSearch,
    loadData
})

function handlePage(url) {
    if (url) {
        // Extracting the page number from the URL
        const pageMatch = url.match(/page=(\d+)/);
        const page = pageMatch ? pageMatch[1] : 1;

        // Adding search to the URL if there is a search value
        loadData(page)
    }
}

function handleSpecificPage(page) {
    loadData(page)
}

function deleteConfirm(course) {
    selectedCourse.value = course
    openDelete.value = true
}

function editCourse(course) {
    selectedCourse.value = course
    openEdit.value = true
}

function confirmDelete() {
    axios.post(route('admin.courses.delete', selectedCourse.value.id))
        .then(response => {
            openDelete.value = false;
            // Additional logic or UI updates on success
            flashNotifShow.value = true
            flashNotifInfos.header = `Course deleted successfully`
            loadData(1)
        })
        .catch(error => {
            // Handle error
            console.error('Delete error:', error);
          
        });
}

const form = useForm({
    id: null,
});


function handleShow(course) {
    router.visit(route('admin.courses.show', course.slug));
}


function handleToggle(course) {
    form.id = course.id
    form.patch(route('admin.courses.toggleStatus', course.id), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            loadData()
        },
    });
}
 
</script>

<template>
    <div class="px-4 sm:px-6 lg:px-8">
    
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                            <tr>
                                <th scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Code</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Name</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">No. of Topics</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">No. of Assessments</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr v-for="(course, index) in courses.data" :key="index">
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-bold text-primary sm:pl-0 hover:text-primary-darker cursor-pointer hover:underline" @click="handleShow(course)">
                                    {{ course.code }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-primary hover:text-primary-darker cursor-pointer hover:underline" @click="handleShow(course)">
                                    {{ course.name }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ course.topics.length }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ course.assessments.length }}</td>
                                
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <toggle :value="course.status ? true : false" type="success" @toggle-value="handleToggle(course)"/>
                                </td>
                                <td
                                    class="relative whitespace-nowrap inline-flex items-center py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                        <pencil-alt-icon @click="editCourse(course)"  class="mx-1 text-medium-gray w-5 h-5 cursor-pointer" />
                                        <TrashIcon @click="deleteConfirm(course)" class="text-medium-gray cursor-pointer"/>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
       
    </div>
    <Pagination class="mt-4 px-2"
                :current_page="courses.current_page" 
                :last_page="courses.last_page"
                :next_page_url="courses.next_page_url"
                :prev_page_url="courses.prev_page_url"
                :path="courses.path"
                :pagination="courses"
                :search="search"
                :sort_column="sortColumn"
                :sort_direction="sortDirection"
                @emit-page="handlePage"
                @emit-specific-page="handleSpecificPage"
                :total_pages="courses.total"
    />
    <DeleteConfirmModal :open="openDelete" @close="openDelete = false" @handleSubmit="confirmDelete"/>
    <EditCourseModal :open="openEdit"
                :course="selectedCourse"
                @close="openEdit = false"
                @refreshDataTable="loadData(1)"/>
    <flash-notifications-front-end :infos="flashNotifInfos" icon="info" :state="flashNotifShow"
                @close="flashNotifShow = false" />

</template>