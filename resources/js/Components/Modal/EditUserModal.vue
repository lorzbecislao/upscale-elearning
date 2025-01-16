<script setup>
import { useForm } from "@inertiajs/vue3"
import Modal from "@/Components/Shared/Modal.vue"
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue"
import SecondaryButton from "@/Components/Shared/SecondaryButton.vue"
import { ref, onMounted, watch, computed } from "vue";
import TextInput from "@/Components/Shared/TextInput.vue"
import SelectInput from "@/Components/Shared/SelectInput.vue";

// emits
const emits = defineEmits(['close', 'refreshDataTable'])

// props
const props = defineProps({
    open: Boolean,
    user: Object
})

// data
const form = useForm({
    name: props.user ? props.user.name : null,
    email: props.user ? props.user.email : null,
});

// methods
function close() {
    form.name = ''
    form.email = ''
    emits('close')
}

watch(() => props.user, (newUser) => {
    if (newUser) {
        form.name = newUser.name;
        form.email = newUser.email;
    }
});


const submit = () => {
    form.post(route('admin.users.update', props.user.id), {
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
                Update Admin Details
            </h5>
            <!-- Forms -->
            <form @submit.prevent="submit">
                <div class="pt-6">
                    <text-input v-model="form.name" :required="true"
                        :errors="form.errors ? form.errors.name : []" label="Name" />
                </div>
                <div class="pt-6">
                    <text-input type="email" v-model="form.email" :required="true"
                        :errors="form.errors ? form.errors.email : []" label="Email Address" />
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
