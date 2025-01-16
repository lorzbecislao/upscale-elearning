<script setup>
import { useForm } from "@inertiajs/vue3"
import Modal from "@/Components/Shared/Modal.vue"
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue"
import SecondaryButton from "@/Components/Shared/SecondaryButton.vue"
import { ref, onMounted, watch, computed } from "vue";
import TextInput from "@/Components/Shared/TextInput.vue"
import SingleUploadSection from "@/Components/Shared/SingleUploadSection.vue"
import SelectInput from "@/Components/Shared/SelectInput.vue"


// emits
const emits = defineEmits(['close', 'refreshDataTable'])

// props
const props = defineProps({
    open: Boolean,
    student: Object,
    programs: Array
})


// data
const form = useForm({
    student_number: props.student ? props.student.student_number : null,
    email: props.student ? props.student.email : null,
    first_name: props.student ? props.student.first_name : null,
    last_name: props.student ? props.student.last_name : null,
    program_id: props.student ? props.student.program_id : null,

});

watch(() => props.student, (newStudent) => {
    if (newStudent) {
        form.student_number = newStudent.student_number;
        form.email = newStudent.email;
        form.first_name = newStudent.first_name;
        form.last_name = newStudent.last_name;
        form.program_id = newStudent.program_id;
    }
});

// methods
function close() {
    form.student_number = props.student.student_number
    form.email = props.student.email
    form.first_name = props.student.first_name
    form.last_name = props.student.last_name
    form.program_id = props.student.program_id


    emits('close')
}

const submit = () => {
    form.post(route('admin.students.update', props.student.id), {
        onSuccess: () => {
            close();
            form.student_number = ''
            form.email = ''
            form.first_name = ''
            form.last_name = ''
            form.program_id = ''
            emits('refreshDataTable')
        },
    });
};

</script>
<template>
    <Modal :open="open" @close="close">
        <template v-slot:content>
            <h5 class="font-heading font-bold text-black-darkest">
                Update Student
            </h5>
            <!-- Forms -->
            <form @submit.prevent="submit">
                <div class="pt-6">
                    <text-input :max="8" :min="8" v-model="form.student_number" :required="true"
                        :errors="form.errors ? form.errors.student_number : []" label="Student Number" />
                </div>
                <div class="pt-6">
                    <text-input v-model="form.email" :errors="form.errors ? form.errors.email : []"
                        label="Email Address" :required="true" />
                </div>
                <div class="pt-6 grid grid-cols-2 gap-6">
                    <text-input v-model="form.first_name" :errors="form.errors ? form.errors.first_name : []"
                        label="First Name" :required="true" />
                    <text-input v-model="form.last_name" :errors="form.errors ? form.errors.last_name : []"
                        label="Last Name" :required="true" />
                </div>

                <div class="pt-6">
                    <select-input id="select-program" v-model="form.program_id" :value="form.program_id">
                        <option v-for="(program, index) in programs" :key="index" :value=program.value>
                            {{ program.label }}
                        </option>
                    </select-input>
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
    </Modal>
</template>
