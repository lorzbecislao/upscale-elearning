<script setup>

import { ref, onMounted, watch } from 'vue';
import { router, useForm } from '@inertiajs/vue3'
import Pagination from '@/Components/Shared/Pagination.vue';
import SearchInput from "@/Components/Shared/SearchInput.vue"
import TrashIcon from '@/Components/Icon/TrashIcon.vue';
import { PencilAltIcon } from "@heroicons/vue/outline"
import DeleteConfirmModal from "@/Components/Modal/DeleteConfirmModal.vue"
import EditAssessmentModal from "@/Components/Modal/EditAssessmentModal.vue"
import FlashNotificationsFrontEnd from "@/Components/Shared/FlashNotificationsFrontEnd.vue"
import Toggle from "@/Components/Shared/Toggle.vue"
import InformationCircleIcon from "@/Components/Icon/InformationCircleIcon.vue";


const props = defineProps({
    courses: Array
})

onMounted(() => {
    loadData();
})

const search = ref(null);
const sortColumn = ref('id');
const sortDirection = ref('asc');
const assessments = ref([]);
const openDelete = ref(false);
const openEdit = ref(false);
const selectedAssessment = ref(null)
const flashNotifShow = ref(false)
const flashNotifInfos = { icon: 'check', header: null }

const loadData = (page = 1) => {
    axios.get(`/admin/assessments/data-table`, {
        params: {
            page: page,
            search: search.value,
            sort_column: sortColumn.value,
            sort_direction: sortDirection.value
        }
    })
        .then(response => {
            assessments.value = response.data;
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

function deleteConfirm(assessment) {
    selectedAssessment.value = assessment
    openDelete.value = true
}

function confirmDelete() {
    axios.post(route('admin.assessments.delete', selectedAssessment.value.id))
        .then(response => {
            openDelete.value = false;
            // Additional logic or UI updates on success
            flashNotifShow.value = true
            flashNotifInfos.header = `Assessment deleted successfully`
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


function handleShow(assessment) {
    router.visit(route('admin.assessments.show', assessment.id));
}


function handleToggle(assessment) {
    form.id = assessment.id
    form.patch(route('admin.assessments.toggleStatus', assessment.id), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            loadData()
        },
    });
}

function editAssessment(assessment) {
    selectedAssessment.value = assessment
    openEdit.value = true
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
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Title
                                </th>
                                <th scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                    <div class="inline-flex items-center">
                                        <span>Topic</span>
                                        <button class="ml-1.5"
                                            v-tooltip="{ content: 'Assessment will show after this topic' }">
                                            <information-circle-icon class="w-5 h-5 text-medium-gray">
                                            </information-circle-icon>
                                        </button>
                                    </div>

                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Course
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Type
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status
                                </th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr v-for="(assessment, index) in assessments.data" :key="index">
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-bold text-primary sm:pl-0 hover:text-primary-darker cursor-pointer hover:underline"
                                    @click="handleShow(assessment)">
                                    {{  assessment.title }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-primary">
                                    {{ assessment.after_topic ? assessment.after_topic.title : '--' }}
                                </td>

                                <td class="whitespace-nowrap px-3 py-4 text-sm text-primary">
                                    {{ assessment.course ? assessment.course.name : '--' }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-primary">
                                    {{ assessment.type === 1 ? 'Practical' : 'Quiz' }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <toggle :value="assessment.status ? true : false" type="success"
                                        @toggle-value="handleToggle(assessment)" />
                                </td>
                                <td
                                    class="relative whitespace-nowrap inline-flex items-center py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                    <pencil-alt-icon @click="editAssessment(assessment)"
                                        class="mx-1 text-medium-gray w-5 h-5 cursor-pointer" />
                                    <TrashIcon @click="deleteConfirm(assessment)"
                                        class="text-medium-gray cursor-pointer" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <Pagination class="mt-4 px-2" :current_page="assessments.current_page" :last_page="assessments.last_page"
        :next_page_url="assessments.next_page_url" :prev_page_url="assessments.prev_page_url" :path="assessments.path"
        :pagination="assessments" :search="search" :sort_column="sortColumn" :sort_direction="sortDirection"
        @emit-page="handlePage" @emit-specific-page="handleSpecificPage" :total_pages="assessments.total" />
    <DeleteConfirmModal :open="openDelete" @close="openDelete = false" @handleSubmit="confirmDelete" />
    <EditAssessmentModal :open="openEdit" :assessment="selectedAssessment" @close="openEdit = false"
        @refreshDataTable="loadData(1)" :courses="courses" />
    <flash-notifications-front-end :infos="flashNotifInfos" icon="info" :state="flashNotifShow"
        @close="flashNotifShow = false" />
</template>