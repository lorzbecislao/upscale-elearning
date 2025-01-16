<script setup>
import {ChatAltIcon} from "@heroicons/vue/outline"
import {useForm, usePage} from "@inertiajs/vue3"
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue"
import SecondaryButton from "@/Components/Shared/SecondaryButton.vue"
import TextInput from "@/Components/Shared/TextInput.vue"

const props = defineProps({
  forum: Object
})

const form = useForm({
  comment: null
})

function cancel() {
  form.comment = null
}

function submit() {
  let url = usePage().props.auth.user.user_type === 2 ? 'forums.comment' : 'admin.forums.comment'
  form.post(route(url, props.forum.id), {
    onSuccess: () => {
      form.comment = null
    }
  })
}
</script>
<template>
    <div v-if="$page.props.auth.user.forum_full_access == true"
        class="bg-white border border-gray-200 rounded-lg shadow-lg py-5 px-14">
        <form @submit.prevent="submit">
            <div class="pt-4">
                <text-input :max="256" v-model="form.comment" input-class="!border-[#DFE4EA]"
                    placeholder="Type here your wise comment" :required="true" />
            </div>
            <div class="mt-6 flex justify-end gap-6">
                <secondary-button class="text-gray-dark" type="button" @click="cancel">
                    Cancel
                </secondary-button>
                <primary-button type="submit">
                    <chat-alt-icon class="w-5 h-5" />
                    Submit
                </primary-button>
            </div>
        </form>
    </div>
</template>