<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Tiptap from '@/Components/Tiptap.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/Shared/PrimaryButton.vue';
import { ref } from 'vue';
import TextInput from "@/Components/Shared/TextInput.vue"
import SearchSelect from "@/Components/Shared/SearchSelect.vue"

const props = defineProps({
    assessment: Object,
})

const form = useForm({
    content: props.assessment.content ? props.assessment.content : 'Start editing your own content by editing here',
})

const modalOpen = ref(false)

function submitForm() {
    form.patch(route('admin.assessments.updatePracticalContent', props.assessment.id), {
        preserveScroll: true,
        onSuccess: () => {
        }
    })
}

</script>

<template>

    <Head title="Create Practical Assessment" />
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form @submit.prevent="submitForm" class="space-y-8">
                    <tiptap v-model="form.content" />
                    <div class="flex justify-end">
                        <primary-button @click="modalOpen = true" class="!px-12">
                            Save
                        </primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
