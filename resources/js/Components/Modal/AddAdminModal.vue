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

})

// data
const form = useForm({
    name: null,
    email: null,
 
});

// methods
function close() {
    form.name = ''
    form.email = ''
    emits('close')
}

const submit = () => {
    form.post(route('admin.users.store'), {
        onSuccess: () => {
            close();
            form.name = ''
            form.email = ''
            emits('refreshDataTable')
        },
    });
};

</script>
<template>
    <Modal :open="open" @close="close">
        <template v-slot:content>
            <h5 class="font-heading font-bold text-black-darkest">
                Create New Administrator Account
            </h5>
            <!-- Forms -->
            <form @submit.prevent="submit">
                <div class="pt-6">
                    <text-input :max="256" v-model="form.name" :errors="form.errors ? form.errors.name : []"
                        label="Name" :required="true" />
                </div>
                <div class="pt-6">
                    <text-input type="email" v-model="form.email" label="Email Address"
                        :errors="form.errors ? form.errors.email : []" :required="true" />
                </div>
                <div class="pt-6">
                    <p class="text-sm text-green-600">An email will be sent to the provided address. Ensure it is active
                        and accessible.</p>
                </div>
                <div class="pt-6 flex justify-end gap-3">
                    <secondary-button type="button" @click="close">
                        Cancel
                    </secondary-button>
                    <primary-button class="!px-8" type="submit">
                        Create
                    </primary-button>
                </div>
            </form>
        </template>
    </Modal>
</template>
