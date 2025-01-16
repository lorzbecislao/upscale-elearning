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
    assessment: Object,
})

// data
const form = useForm({
    question: null,
    option_a: null,
    option_b: null,
    option_c: null,
    option_d: null,
    answer: null,
    assessment_id: props.assessment ? props.assessment.id : null
});

// methods
function close() {
    form.question = ''
    form.option_a = ''
    form.option_b = ''
    form.option_c = ''
    form.option_d = ''
    form.answer = null
    emits('close')
}

const submit = () => {
    form.post(route('admin.questions.store'), {
        onSuccess: () => {
            close();
            form.question = ''
            form.option_a = ''
            form.option_b = ''
            form.option_c = ''
            form.option_d = ''
            form.answer = null
            emits('refreshDataTable')
        },
    });
};

const options = [
    { id: 1, title: 'A' },
    { id: 2, title: 'B' },
    { id: 3, title: 'C' },
    { id: 4, title: 'D' },
]

function handleChangeType(id) {
    form.answer = id;
}

</script>
<template>
    <Modal :open="open" @close="close">
        <template v-slot:content>
            <h5 class="font-heading font-bold text-black-darkest">
                Add New Question
            </h5>
            <!-- Forms -->
            <form @submit.prevent="submit">
                <div class="pt-3">
                    <label class="block text-sm font-medium font-heading text-dark-gray-dark">Question</label>
                    <textarea
                        class="mt-1 form-input block w-full py-2.5 px-3 border-medium-dark focus:ring-primary border border-medium-gray font-heading rounded-md shadow-sm focus:outline-none focus:ring-1 focus:border-transparent text-sm"
                        placeholder="Type here..." v-model="form.question" required rows="3" />
                </div>
                <div class="pt-3 grid grid-cols-2 gap-2">
                    <text-input v-model="form.option_a" label="Option A" :required="true" />
                    <text-input v-model="form.option_b" label="Option B" :required="true" />
                    <text-input v-model="form.option_c" label="Option C" :required="true" />
                    <text-input v-model="form.option_d" label="Option D" :required="true" />
                </div>
                <div class="pt-6">
                    <label class="block text-sm font-medium font-heading text-dark-gray-dark">
                        Right Answer
                    </label>
                    <div v-for="(type, index) in options" :key="type.id" class="inline-flex items-center mt-3">
                        <input :id="type.id" @input="handleChangeType(type.id)" required name="options-radio" type="radio"
                            v-model="form.answer" :value="type.id"
                            class="h-4 w-4 border-gray-300 text-primary focus:ring-primary cursor-pointer" />
                        <label :for="type.id" class="mx-3 block text-sm font-medium text-gray-700">{{ type.title
                            }}</label>
                    </div>
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
