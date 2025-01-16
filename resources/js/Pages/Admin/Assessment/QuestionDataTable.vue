<script setup>

import { ref, onMounted, watch } from 'vue';
import { router, useForm } from '@inertiajs/vue3'
import Pagination from '@/Components/Shared/Pagination.vue';
import SearchInput from "@/Components/Shared/SearchInput.vue"
import TrashIcon from '@/Components/Icon/TrashIcon.vue';
import { PencilAltIcon } from "@heroicons/vue/outline"
import DeleteConfirmModal from "@/Components/Modal/DeleteConfirmModal.vue"
import EditQuestionModal from "@/Components/Modal/EditQuestionModal.vue"
import FlashNotificationsFrontEnd from "@/Components/Shared/FlashNotificationsFrontEnd.vue"
import Toggle from "@/Components/Shared/Toggle.vue"

const props = defineProps({
    courses: Array,
    assessment: { type: Object, default: () => { } },
})

onMounted(() => {
    loadData();
})

const search = ref(null);
const sortColumn = ref('id');
const sortDirection = ref('asc');
const questions = ref([]);
const openDelete = ref(false);
const openEdit = ref(false);
const selectedQuestion = ref(null)
const flashNotifShow = ref(false)
const flashNotifInfos = { icon: 'check', header: null }

const loadData = (page = 1) => {
    axios.get(`/admin/questions/data-table`, {
        params: {
            assessment_id: props.assessment.id,
            page: page,
            search: search.value,
            sort_column: sortColumn.value,
            sort_direction: sortDirection.value
        }
    })
        .then(response => {
            questions.value = response.data;
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

function deleteConfirm(question) {
    selectedQuestion.value = question
    openDelete.value = true
}

function confirmDelete() {
    axios.post(route('admin.questions.delete', selectedQuestion.value.id))
        .then(response => {
            openDelete.value = false;
            // Additional logic or UI updates on success
            flashNotifShow.value = true
            flashNotifInfos.header = `Question deleted successfully`
            loadData(1)
        })
        .catch(error => {
            // Handle error
            console.error('Delete error:', error);

        });
}

function editQuestion(question) {
    selectedQuestion.value = question
    openEdit.value = true
}

function getAnswer(answer) {
    if (answer == 1) {
        return 'A'
    } else if (answer == 2) {
        return 'B'
    } else if (answer == 3) {
        return 'C'
    } else {
        return 'D'
    }
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
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 text-wrap">
                                    Question
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Options
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Answer
                                </th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr v-for="(item, index) in questions.data" :key="index">
                                <td class="text-wrap px-3 py-4 text-sm text-primary w-1/2">
                                    {{ item.question }}
                                </td>
                                <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="font-medium text-gray-900">A. {{ item.option_a }}</div>
                                            <div class="font-medium text-gray-900">B. {{ item.option_b }}</div>
                                            <div class="font-medium text-gray-900">C. {{ item.option_c }}</div>
                                            <div class="font-medium text-gray-900">D. {{ item.option_d }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ getAnswer(item.answer) }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <div class="inline-flex items-center">
                                        <pencil-alt-icon @click="editQuestion(item)"
                                            class="mx-1 text-medium-gray w-5 h-5 cursor-pointer" />
                                        <TrashIcon @click="deleteConfirm(item)"
                                            class="text-medium-gray cursor-pointer" />
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <Pagination class="mt-4 px-2" :current_page="questions.current_page" :last_page="questions.last_page"
        :next_page_url="questions.next_page_url" :prev_page_url="questions.prev_page_url" :path="questions.path"
        :pagination="questions" :search="search" :sort_column="sortColumn" :sort_direction="sortDirection"
        @emit-page="handlePage" @emit-specific-page="handleSpecificPage" :total_pages="questions.total" />
    <DeleteConfirmModal :open="openDelete" @close="openDelete = false" @handleSubmit="confirmDelete" />
    <EditQuestionModal :open="openEdit" :question="selectedQuestion" @close="openEdit = false"
        @refreshDataTable="loadData(1)"  />
    <flash-notifications-front-end :infos="flashNotifInfos" icon="info" :state="flashNotifShow"
        @close="flashNotifShow = false" />
</template>