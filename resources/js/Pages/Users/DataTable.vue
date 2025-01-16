<script setup>
import TrashIcon from '@/Components/Icon/TrashIcon.vue';
import { PencilAltIcon } from "@heroicons/vue/outline"
import Badge from "@/Shared/Icons/Badge.vue"
import { watch, ref, onMounted, computed } from "vue"
import EditUserModal from "@/Components/Modal/EditUserModal.vue"
import Pagination from '@/Components/Shared/Pagination.vue';
import Toggle from "@/Components/Shared/Toggle.vue"
import { router, useForm } from '@inertiajs/vue3'
import DeleteConfirmModal from "@/Components/Modal/DeleteConfirmModal.vue"
import FlashNotificationsFrontEnd from "@/Components/Shared/FlashNotificationsFrontEnd.vue"

// props
const props = defineProps({
    perPage: Number,
    searchInput: String,
})

const editUserOpen = ref(false)
const search = ref(null);
const sortColumn = ref('id');
const sortDirection = ref('asc');
const admins = ref([]);
const selectedUser = ref(null)
const openDelete = ref(false)
const flashNotifShow = ref(false)
const flashNotifInfos = { icon: 'check', header: null }


const loadData = (page = 1) => {
    axios.get(`/admin/users/administrators/data-table`, {
        params: {
            page: page,
            search: search.value,
            sort_column: sortColumn.value,
            sort_direction: sortDirection.value
        }
    })
        .then(response => {
            admins.value = response.data;
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


function deleteConfirm(user) {
    selectedUser.value = user
    openDelete.value = true
}

function handleEdit(user) {
    selectedUser.value = user
    editUserOpen.value = true
}

const form = useForm({
    id: null,
});


function handleToggle(admin) {
    form.id = admin.id
    form.patch(route('admin.users.toggleStatus', admin), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            loadData()
        },
    });
}

function confirmDelete() {
    axios.post(route('admin.users.delete', selectedUser.value.id))
        .then(response => {
            openDelete.value = false;
            // Additional logic or UI updates on success
            flashNotifShow.value = true
            flashNotifInfos.header = `Admin account deleted successfully`
            loadData(1)
        })
        .catch(error => {
            // Handle error
            console.error('Delete error:', error);

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
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Name
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Status</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr v-for="(admin, index) in admins.data" :key="index">
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-primary hover:text-primary-darker cursor-pointer hover:underline"
                                    @click="handleShow(admin)">
                                    {{ admin.name }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ admin.email }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <toggle :value="admin.status ? true : false" type="success"
                                        @toggle-value="handleToggle(admin)" />
                                </td>

                                <td
                                    class="relative whitespace-nowrap inline-flex items-center py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                    <pencil-alt-icon @click="handleEdit(admin)"
                                        class="mx-1 text-medium-gray w-5 h-5 cursor-pointer" />
                                    <TrashIcon @click="deleteConfirm(admin)" class="text-medium-gray cursor-pointer" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <edit-user-modal :open="editUserOpen" @close="editUserOpen = false" :user="selectedUser"
                @refreshDataTable="loadData(1)" />
            <DeleteConfirmModal :open="openDelete" @close="openDelete = false" @handleSubmit="confirmDelete" />
        </div>

    </div>

    <Pagination class="mt-4 px-2" :current_page="admins.current_page" :last_page="admins.last_page"
        :next_page_url="admins.next_page_url" :prev_page_url="admins.prev_page_url" :path="admins.path"
        :pagination="admins" :search="search" :sort_column="sortColumn" :sort_direction="sortDirection"
        @emit-page="handlePage" @emit-specific-page="handleSpecificPage" :total_pages="admins.total" />
    <flash-notifications-front-end :infos="flashNotifInfos" icon="info" :state="flashNotifShow"
        @close="flashNotifShow = false" />
</template>