<script setup>
import { useForm } from "@inertiajs/vue3"
import Modal from "@/Components/Shared/Modal.vue"
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue"
import SecondaryButton from "@/Components/Shared/SecondaryButton.vue"
import { ref, onMounted, watch, computed } from "vue";
import TextInput from "@/Components/Shared/TextInput.vue"

// emits
const emits = defineEmits(['close', 'refreshDataTable'])

// props
const props = defineProps({
    open: Boolean,
    course: Object
})

// data
const form = useForm({
    title: null,
    course_id: props.course.id
});

// methods
function close() {
    form.title = ''
    emits('close')
}

const submit = () => {
    form.post(route('admin.topics.store'), {
        onSuccess: () => {
            close();
            form.title = ''
            emits('refreshDataTable')
        },
    });
};

</script>
<template>
    <Modal :open="open" @close="close">
        <template v-slot:content>
            <h5 class="font-heading font-bold text-black-darkest">
                Add New Topic
            </h5>
            <!-- Forms -->
            <form @submit.prevent="submit">
                <div class="pt-6">
                    <text-input :max="256" v-model="form.title" :errors="form.errors ? form.errors.title : []"
                        label="Title" />
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
