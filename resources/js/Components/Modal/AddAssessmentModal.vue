<script setup>
import { useForm } from "@inertiajs/vue3"
import Modal from "@/Components/Shared/Modal.vue"
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue"
import SecondaryButton from "@/Components/Shared/SecondaryButton.vue"
import { ref, onMounted, watch, computed } from "vue";
import TextInput from "@/Components/Shared/TextInput.vue"
import SingleUploadSection from "@/Components/Shared/SingleUploadSection.vue"
import SearchSelect from "@/Components/Shared/SearchSelect.vue"
import InformationCircleIcon from "@/Components/Icon/InformationCircleIcon.vue";
import Tiptap from '@/Components/Tiptap.vue';


// emits
const emits = defineEmits(['close', 'refreshDataTable'])

// props
const props = defineProps({
    open: Boolean,
    courses: Array
})

// data
const form = useForm({
    title: null,
    course_id: null,
    topic_id: null,
    instruction: null,
    type: null
});

// methods
function close() {
    form.course_id = ''
    form.topic_id = '' 
    form.instruction = ''
    form.type = ''
    form.title = ''
    emits('close')
}

const submit = () => {
    form.post(route('admin.assessments.store'), {
        onSuccess: () => {
            close();
            form.title = ''
            form.course_id = ''
            form.topic_id = ''
            form.instruction = ''
            form.type = ''
            emits('refreshDataTable')
        },
    });
};

const topics = ref([])

const assessmentTypes = [
    { id: 1, title: 'Pratical' },
    { id: 2, title: 'Quiz' },
]

function handleChangeType(id) {
    form.type = id;
}

function selectCourse(event) {

    axios.get(`/admin/topics/${event.id}/get-all`)
        .then(response => {
            if (response.data) {
                topics.value = response.data
            }
        });
}


</script>
<template>
    <Modal :open="open" @close="close">
        <template v-slot:content>
            <h5 class="font-heading font-bold text-black-darkest">
                Add New Assessment
            </h5>
            <!-- Forms -->
            <form @submit.prevent="submit">
                <div class="pt-6">
                    <text-input :max="100" v-model="form.title" :errors="form.errors ? form.errors.title : []"
                        label="Assessment Title" :required="true" />
                </div>
                <div class="pt-6">
                    <label class="block text-sm font-medium font-heading text-dark-gray-dark mb-2">
                        Course
                    </label>
                    <search-select :options="courses" v-model="form.course_id" @option:selected="selectCourse($event)"
                        :errors=" form.errors ? form.errors.course_id : []" :value="form.course_id" />
                </div>
                <div class="pt-6">
                    <div class="inline-flex items-center">
                        <label class="block text-sm font-medium font-heading text-dark-gray-dark mb-2">
                            Topic
                        </label>
                        <button class="-mt-1 ml-1"
                            v-tooltip="{ content: 'Assessment will show after this selected topic' }">
                            <information-circle-icon class="w-5 h-5 text-medium-gray">
                            </information-circle-icon>
                        </button>
                    </div>
                    <search-select :options="topics" v-model="form.topic_id"
                        :errors="form.errors ? form.errors.topic_id : []" :value="form.topic_id" />
                </div>
                <div class="pt-6">
                    <label class="block text-sm font-medium font-heading text-dark-gray-dark">
                        Assessment Type
                    </label>
                    <div v-for="(type, index) in assessmentTypes" :key="type.id" class="inline-flex items-center mt-3">
                        <input :id="type.id" @input="handleChangeType(type.id)" name="type-radio" required type="radio"
                            v-model="form.type" :value="type.id"
                            class="h-4 w-4 border-gray-300 text-primary focus:ring-primary cursor-pointer" />
                        <label :for="type.id" class="mx-3 block text-sm font-medium text-gray-700">{{ type.title
                            }}</label>
                    </div>
                </div>
                <div class="pt-3">
                    <label class="block text-sm font-medium font-heading text-dark-gray-dark">Instruction</label>
                    <textarea
                        class="mt-1 form-input block w-full py-2.5 px-3 border-medium-dark focus:ring-primary border border-medium-gray font-heading rounded-md shadow-sm focus:outline-none focus:ring-1 focus:border-transparent text-sm"
                        placeholder="Type here..." v-model="form.instruction" required rows="3" />
                </div>
                <div class="pt-6 flex justify-end gap-3">
                    <secondary-button type="button" @click="close">
                        Cancel
                    </secondary-button>
                    <primary-button class="!px-8" type="submit">
                        Add
                    </primary-button>
                </div>
            </form>
        </template>
    </Modal>
</template>
