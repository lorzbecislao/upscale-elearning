<script setup>

import { ref, onMounted, watch } from 'vue';
import { router, useForm } from '@inertiajs/vue3'
import Pagination from '@/Components/Shared/Pagination.vue';
import SearchInput from "@/Components/Shared/SearchInput.vue"
import TrashIcon from '@/Components/Icon/TrashIcon.vue';
import { PencilAltIcon } from "@heroicons/vue/outline"
import DeleteConfirmModal from "@/Components/Modal/DeleteConfirmModal.vue"
import FlashNotificationsFrontEnd from "@/Components/Shared/FlashNotificationsFrontEnd.vue"
import Moment from 'moment'
import Toggle from "@/Components/Shared/Toggle.vue"

const props = defineProps({
    course: Object
})

onMounted(() => {
    loadData();
})

const search = ref(null);
const sortColumn = ref('id');
const sortDirection = ref('asc');
const topics = ref([]);
const openDelete = ref(false);
const selectedTopic = ref(null)
const flashNotifShow = ref(false)
const flashNotifInfos = { icon: 'check', header: null }

const loadData = (page = 1) => {
    axios.get(`/admin/topics/data-table`, {
        params: {
            page: page,
            search: search.value,
            sort_column: sortColumn.value,
            sort_direction: sortDirection.value,
            course_id: props.course.id
        }
    })
        .then(response => {
            topics.value = response.data;
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

const form = useForm({
    id: null,
});

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

function deleteConfirm(topic) {
    selectedTopic.value = topic
    openDelete.value = true
}

function confirmDelete() {
    axios.post(route('admin.topics.delete', selectedTopic.value.id))
        .then(response => {
            openDelete.value = false;
            // Additional logic or UI updates on success
            flashNotifShow.value = true
            flashNotifInfos.header = `Topic deleted successfully`
            loadData(1)
        })
        .catch(error => {
            // Handle error
            console.error('Delete error:', error);

        });
}

function editTopic(topic) {
    router.visit(route('admin.topics.edit', topic.slug));
}

function handleToggle(topic) {
    form.id = topic.id
    form.patch(route('admin.topics.toggleStatus', topic.id), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            loadData()
        },
    });
}

</script>

<template>

    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                        <tr>
                            <th scope="col"
                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Title
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Created At
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Created By
                            </th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr v-for="(topic, index) in topics.data" :key="index">
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-bold text-primary sm:pl-0">
                                {{ topic.title }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                <toggle :value="topic.status ? true : false" type="success"
                                    @toggle-value="handleToggle(topic)" />
                            </td>

                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{
                                Moment(topic.created_at).format('MMM DD, YYYY') }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ topic.createdBy }}</td>
                            <td
                                class="relative whitespace-nowrap inline-flex items-center py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <pencil-alt-icon @click="editTopic(topic)"
                                    class="mx-1 text-medium-gray w-5 h-5 cursor-pointer" />
                                <TrashIcon @click="deleteConfirm(topic)" class="text-medium-gray cursor-pointer" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <Pagination class="mt-4 px-2" :current_page="topics.current_page" :last_page="topics.last_page"
        :next_page_url="topics.next_page_url" :prev_page_url="topics.prev_page_url" :path="topics.path"
        :pagination="topics" :search="search" :sort_column="sortColumn" :sort_direction="sortDirection"
        @emit-page="handlePage" @emit-specific-page="handleSpecificPage" :total_pages="topics.total" />
    <DeleteConfirmModal :open="openDelete" @close="openDelete = false" @handleSubmit="confirmDelete" />
    <flash-notifications-front-end :infos="flashNotifInfos" icon="info" :state="flashNotifShow"
        @close="flashNotifShow = false" />
</template>