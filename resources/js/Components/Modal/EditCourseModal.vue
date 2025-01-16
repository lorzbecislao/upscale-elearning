<script setup>
import { useForm } from "@inertiajs/vue3"
import Modal from "@/Components/Shared/Modal.vue"
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue"
import SecondaryButton from "@/Components/Shared/SecondaryButton.vue"
import { ref, onMounted, watch, computed } from "vue";
import TextInput from "@/Components/Shared/TextInput.vue"
import SingleUploadSection from "@/Components/Shared/SingleUploadSection.vue"

// emits
const emits = defineEmits(['close', 'refreshDataTable'])

// props
const props = defineProps({
    open: Boolean,
    course: Object
})

const files = ref(props.course ? props.course.image_url : null)

function handleUpload(uploadedFiles) {
    files.value = uploadedFiles
}

function handleClear() {
    files.value = null
}

// data
const form = useForm({
    name: props.course ? props.course.name : null,
    code: props.course ? props.course.code : null,
    description: props.course ? props.course.description : null,
    image: props.course ? props.course.image_url : null
});

watch(() => props.course, (newCourse) => {
    if (newCourse) {
        form.name = newCourse.name;
        form.code = newCourse.code;
        form.description = newCourse.description;
        form.image = newCourse.image_url;
    }
});

// methods
function close() {
    form.name = props.course.name
    form.code = props.course.code
    form.description = props.course.description
    form.image = props.course.image_url 
    emits('close')
}

const submit = () => {
    form.image = files.value
    form.post(route('admin.courses.update', props.course.id), {
        onSuccess: () => {
            close();
            form.name = ''
            form.code = ''
            form.description = ''
            form.image = ''
            emits('refreshDataTable')
        },
    });
};

</script>
<template>
    <Modal :open="open" @close="close">
        <template v-slot:content>
            <h5 class="font-heading font-bold text-black-darkest">
                Update Course
            </h5>
            <!-- Forms -->
            <form @submit.prevent="submit">
                <div class="pt-6">
                    <text-input :max="256" v-model="form.name" :errors="form.errors ? form.errors.name : []"
                        label="Course Name" placeholder="Ex: Advanced Javascript, Advanced HTML5" />
                </div>
                <div class="pt-6">
                    <text-input v-model="form.code" :errors="form.errors ? form.errors.code : []" label="Course Code"
                        :required="true" />
                </div>
                <div class="pt-6">
                    <text-input v-model="form.description" label="Course Description" :required="true" />
                </div>
                <div class="pt-6">
                    <label class="block text-sm font-medium font-heading text-dark-gray-dark" for="image-upload">Course
                        Image</label>
                    <single-upload-section :saved-image="form.image" id="image-upload" type="image-only" @uploaded="handleUpload" @clear="handleClear"
                        class="pt-2" />
                </div>
                <div class="pt-6 flex justify-end gap-3">
                    <secondary-button type="button" @click="close">
                        Cancel
                    </secondary-button>
                    <primary-button class="!px-8" type="submit">
                        Update
                    </primary-button>
                </div>
            </form>
        </template>
</Modal></template>
