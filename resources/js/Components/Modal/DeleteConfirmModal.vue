<script setup>
import { useForm } from "@inertiajs/vue3"
import Modal from "@/Components/Shared/Modal.vue"
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue"
import SecondaryButton from "@/Components/Shared/SecondaryButton.vue"
import { ref, onMounted, watch, computed } from "vue";
import TextInput from "@/Components/Shared/TextInput.vue"

// emits
const emits = defineEmits(['close', 'handleSubmit'])

// props
const props = defineProps({
    open: Boolean,
})

// methods
function close() {
    emits('close')
}

function submit() {
    emits('handleSubmit')
}

</script>
<template>
    <Modal :open="open" @close="close">
        <template v-slot:content>
            <h5 class="font-heading font-bold text-black-darkest">
                Delete Confirm
            </h5>
            <!-- Forms -->
            <form @submit.prevent="submit">
                <h3 class="leading-5 py-5">Are you sure you want to delete this item?</h3>
                <div class="pt-6 flex justify-end gap-3">
                    <secondary-button type="button" @click="close">
                        Cancel
                    </secondary-button>
                    <primary-button class="!px-8" type="submit">
                        Confirm
                    </primary-button>
                </div>
            </form>
        </template>
    </Modal>
</template>
