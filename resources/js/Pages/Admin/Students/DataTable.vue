<script setup>

import { ref, onMounted, watch } from 'vue';
import { router, useForm } from '@inertiajs/vue3'
import Pagination from '@/Components/Shared/Pagination.vue';
import SearchInput from "@/Components/Shared/SearchInput.vue"
import SearchSelect from "@/Components/Shared/SearchSelect.vue"
import SelectInput from "@/Components/Shared/SelectInput.vue"
import TrashIcon from '@/Components/Icon/TrashIcon.vue';
import { PencilAltIcon } from "@heroicons/vue/outline"
import DeleteConfirmModal from "@/Components/Modal/DeleteConfirmModal.vue"
import FlashNotificationsFrontEnd from "@/Components/Shared/FlashNotificationsFrontEnd.vue"
import Toggle from "@/Components/Shared/Toggle.vue"
import EditStudentModal from '@/Components/Modal/EditStudentModal.vue'
import InformationCircleIcon from "@/Components/Icon/InformationCircleIcon.vue";

const props = defineProps({
    programs: Array
})

onMounted(() => {
    loadData();
})

const search = ref(null);
const sortColumn = ref('id');
const sortDirection = ref('asc');
const students = ref([]);
const openDelete = ref(false);
const openEdit = ref(false);
const selectedStudent = ref(null)
const flashNotifShow = ref(false)
const flashNotifInfos = { icon: 'check', header: null }

const loadData = (page = 1) => {
    axios.get(`/admin/users/students/data-table`, {
        params: {
            page: page,
            search: search.value,
            sort_column: sortColumn.value,
            sort_direction: sortDirection.value
        }
    })
        .then(response => {
            students.value = response.data;
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

function deleteConfirm(student) {
    selectedStudent.value = student
    openDelete.value = true
}

function editStudent(student) {
    selectedStudent.value = student
    openEdit.value = true
}

function confirmDelete() {
    axios.post(route('admin.students.delete', selectedStudent.value.id))
        .then(response => {
            openDelete.value = false;
            // Additional logic or UI updates on success
            flashNotifShow.value = true
            flashNotifInfos.header = `Student deleted successfully`
            loadData(1)
        })
        .catch(error => {
            // Handle error
            console.error('Delete error:', error);

        });
}

const form = useForm({
    id: null,
    forumStatus: null
});


function handleShow(course) {
    router.visit(route('admin.courses.show', course.slug));
}


function handleToggle(student) {
    form.id = student.id
    form.patch(route('admin.students.toggleStatus', student.id), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            loadData()
        },
    });
}

const forumStatusDropdown = [
    {
        id: 1,
        value: 1,
        label: 'View Only'
    },
    {
        id: 2,
        value: 2,
        label: 'Full Access'
    },
]

const forumStatus = ref();

function onForumStatusChanged(id) {
    form.id = id
    form.forumStatus = forumStatus.value
    form.post(route('admin.students.update-forum-status', form.id), {
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
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                    Student Number
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Name
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Program</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status
                                </th>
                                <th scope="col"
                                    class="px-3 py-3.5 text-left items-center flex text-sm font-semibold text-gray-900">
                                    Forum
                                    Status
                                    <button class="mt-0.5 ml-1"
                                        v-tooltip="{ content: 'Full Access = Can post, like, and reply' }">
                                        <information-circle-icon class="w-5 h-5 text-medium-gray">
                                        </information-circle-icon>
                                    </button>
                                </th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr v-for="(student, index) in students.data" :key="index">
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-bold text-primary sm:pl-0">
                                    {{ student.student_number }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-primary">
                                    {{ student.full_name }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ student.email
                                    }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ student.program.initial
                                    }}</td>

                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <toggle :value="student.user.status ? true : false" type="success"
                                        @toggle-value="handleToggle(student)" />
                                </td>
                                <td class="whitespace-nowrap px-3 items-center text-sm text-gray-500">
                                    <select-input id="select-forum-status" v-model="forumStatus"
                                        :value="student.forum_status" @change="onForumStatusChanged(student.id)">
                                        <option v-for="(program, index) in forumStatusDropdown" :key="index"
                                            :value=program.value>
                                            {{ program.label }}
                                        </option>
                                    </select-input>
                                </td>
                                <td
                                    class="relative whitespace-nowrap inline-flex items-center py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                    <pencil-alt-icon @click="editStudent(student)"
                                        class="mx-1 text-medium-gray w-5 h-5 cursor-pointer" />
                                    <TrashIcon @click="deleteConfirm(student)"
                                        class="text-medium-gray cursor-pointer" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <Pagination class="mt-4 px-2" :current_page="students.current_page" :last_page="students.last_page"
        :next_page_url="students.next_page_url" :prev_page_url="students.prev_page_url" :path="students.path"
        :pagination="students" :search="search" :sort_column="sortColumn" :sort_direction="sortDirection"
        @emit-page="handlePage" @emit-specific-page="handleSpecificPage" :total_pages="students.total" />
    <DeleteConfirmModal :open="openDelete" @close="openDelete = false" @handleSubmit="confirmDelete" />
    <EditStudentModal :open="openEdit" :student="selectedStudent" :programs="programs" @close="openEdit = false"
        @refreshDataTable="loadData(1)" />
    <flash-notifications-front-end :infos="flashNotifInfos" icon="info" :state="flashNotifShow"
        @close="flashNotifShow = false" />

</template>